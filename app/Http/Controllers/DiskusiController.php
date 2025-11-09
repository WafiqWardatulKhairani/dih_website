<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DiskusiController extends Controller
{
    /**
     * Halaman utama forum diskusi inovasi
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $filter = $request->input('filter', 'Semua');

        $categories = DB::table('academic_innovations')
            ->whereNotNull('category')
            ->where('status', 'publication')
            ->distinct()
            ->pluck('category');

        $academicQuery = DB::table('academic_innovations as ai')
            ->leftJoin('users as u', 'ai.user_id', '=', 'u.id')
            ->select(
                DB::raw("'academic' as source_type"),
                'ai.id',
                'ai.title',
                'ai.category',
                DB::raw('COALESCE(ai.subcategory, "-") as subcategory_name'),
                'ai.author_name',
                'ai.technology_readiness_level',
                'ai.image_path',
                'u.avatar',
                'ai.created_at'
            )
            ->where('ai.status', 'publication');

        $opdQuery = DB::table('opd_innovations as oi')
            ->leftJoin('users as u', 'oi.user_id', '=', 'u.id')
            ->select(
                DB::raw("'opd' as source_type"),
                'oi.id',
                'oi.title',
                'oi.category',
                DB::raw('COALESCE(oi.subcategory, "-") as subcategory_name'),
                'oi.author_name',
                'oi.technology_readiness_level',
                DB::raw('oi.image as image_path'),
                'u.avatar',
                'oi.created_at'
            )
            ->where('oi.status', 'publication');

        if ($search) {
            $academicQuery->where('ai.title', 'like', "%{$search}%");
            $opdQuery->where('oi.title', 'like', "%{$search}%");
        }

        if ($category) {
            $academicQuery->where('ai.category', $category);
            $opdQuery->where('oi.category', $category);
        }

        if ($subcategory) {
            $academicQuery->where('ai.subcategory', $subcategory);
            $opdQuery->where('oi.subcategory', $subcategory);
        }

        $union = $academicQuery->unionAll($opdQuery);
        $innovations = DB::query()->fromSub($union, 'innovations');

        switch ($filter) {
            case 'Terbaru':
                $innovations->orderByDesc('created_at');
                break;
            case 'Terpopuler':
                $innovations->orderByDesc('created_at'); // sementara
                break;
            default:
                $innovations->orderByDesc('created_at');
        }

        $page = $request->input('page', 1);
        $perPage = 12;
        $all = $innovations->get();

        // Ubah path gambar dan avatar langsung dari DB
        $all = $all->map(function ($item) {
            $item->image_url = $item->image_path
                ? asset('storage/' . $item->image_path)
                : asset('images/default-innovation.jpg');

            $item->avatar_url = $item->avatar
                ? asset('storage/' . $item->avatar)
                : asset('images/default-avatar.png');

            $item->created_at = Carbon::parse($item->created_at);

            return $item;
        });

        $currentItems = $all->slice(($page - 1) * $perPage, $perPage)->values();
        $paginatedInnovations = new LengthAwarePaginator(
            $currentItems,
            $all->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $totalUsers = DB::table('users')->count();
        $totalInnovations = DB::table('academic_innovations')->where('status', 'publication')->count()
            + DB::table('opd_innovations')->where('status', 'publication')->count();
        $totalCollaborations = Schema::hasTable('innovation_participants')
            ? DB::table('innovation_participants')->count()
            : 0;

        return view('diskusi.diskusi', compact(
            'paginatedInnovations',
            'categories',
            'totalUsers',
            'totalInnovations',
            'totalCollaborations',
            'category',
            'subcategory',
            'filter',
            'search'
        ));
    }

    /**
     * Ambil subkategori untuk filter
     */
    public function getSubcategories(Request $request)
    {
        $category = $request->query('category');
        if (!$category) return response()->json([]);

        $subcategories = DB::table('academic_innovations')
            ->where('category', $category)
            ->whereNotNull('subcategory')
            ->distinct()
            ->pluck('subcategory');

        return response()->json($subcategories);
    }

    /**
     * Detail inovasi + komentar
     */
    public function detail($type, $id)
    {
        if (!in_array($type, ['academic', 'opd'])) abort(404);
        $table = $type === 'academic' ? 'academic_innovations' : 'opd_innovations';

        $innovation = DB::table($table . ' as t')
            ->leftJoin('users as u', 't.user_id', '=', 'u.id')
            ->select(
                't.*',
                'u.avatar',
                DB::raw($type === 'opd' ? 't.image as image_path' : 't.image_path')
            )
            ->where('t.id', $id)
            ->first();


        if (!$innovation) abort(404);

        $innovation->subcategory_name = $innovation->subcategory_name ?? ($innovation->subcategory ?? '-');
        $innovation->image_url = $innovation->image_path
            ? asset('storage/' . $innovation->image_path)
            : asset('images/default-innovation.jpg');

        $innovation->avatar_url = $innovation->avatar
            ? asset('storage/' . $innovation->avatar)
            : asset('images/default-avatar.png');

        $innovation->created_at = Carbon::parse($innovation->created_at);

        // Ambil komentar dengan info user
        $comments = DB::table('discussion_comments as dc')
            ->leftJoin('users as u', 'dc.user_id', '=', 'u.id')
            ->where('dc.innovation_id', $innovation->id)
            ->where('dc.innovation_type', $type) 
            ->select(
                'dc.*',
                'u.name as user_name',
                'u.role as user_role',
                'u.avatar as user_avatar'
            )
            ->orderByDesc('dc.created_at')
            ->get()
            ->map(function ($c) {
                $c->created_at = Carbon::parse($c->created_at);
                $c->avatar_url = $c->user_avatar
                    ? asset('storage/' . $c->user_avatar)
                    : asset('images/default-avatar.png');
                return $c;
            });


        // Sidebar inovasi lain
        $sidebarInnovations = DB::table('academic_innovations as ai')
            ->leftJoin('discussion_comments as dc', 'ai.id', '=', 'dc.innovation_id')
            ->select('ai.id', 'ai.title', 'ai.category', 'ai.subcategory', 'ai.author_name', DB::raw('COUNT(dc.id) as comments_count'))
            ->where('ai.id', '!=', $innovation->id)
            ->groupBy('ai.id', 'ai.title', 'ai.category', 'ai.subcategory', 'ai.author_name')
            ->orderByDesc('ai.created_at')
            ->limit(5)
            ->get();

        return view('diskusi.diskusi-detail', compact(
            'innovation',
            'type',
            'comments',
            'sidebarInnovations'
        ));
    }

    /**
     * Tambah komentar
     */
    public function addComment(Request $request, $type, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        if (!Auth::check()) return redirect()->route('login');
        if (!in_array($type, ['academic', 'opd'])) abort(404);

        $table = $type === 'academic' ? 'academic_innovations' : 'opd_innovations';
        $innovation = DB::table($table)->where('id', $id)->first();
        if (!$innovation) abort(404);

        DB::table('discussion_comments')->insert([
            'innovation_id' => $id,
            'innovation_type' => $type,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->route('forum-diskusi.detail', ['type' => $type, 'id' => $id])
            ->with('success', 'Komentar berhasil dikirim.');
    }

    /**
     * Hapus komentar
     */
    public function deleteComment($id)
    {
        $comment = DB::table('discussion_comments')->where('id', $id)->first();
        if (!$comment) abort(404);
        if (Auth::id() != $comment->user_id) abort(403);

        DB::table('discussion_comments')->where('id', $id)->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
