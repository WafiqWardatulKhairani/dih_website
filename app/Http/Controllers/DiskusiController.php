<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Subcategory;

class DiskusiController extends Controller
{
    /**
     * Halaman utama forum diskusi
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $subcategoryId = $request->input('subcategory');
        $filter = $request->input('filter', 'Semua');

        // QUERY AKADEMISI
        $academicQuery = DB::table('academic_innovations')
            ->select(
                'id',
                'user_id',
                'title',
                'category',
                DB::raw('NULL as subcategory'),
                'author_name',
                'institution as institution_name',
                'keywords',
                'description',
                'purpose',
                'technology_readiness_level',
                'image_path',
                'document_path',
                'video_url',
                DB::raw("'academic' as author_role"),
                'created_at'
            )
            ->where('status', 'publication');

        // QUERY OPD
        $opdQuery = DB::table('opd_innovations')
            ->select(
                'id',
                DB::raw('NULL as user_id'),
                'title',
                'category',
                'subcategory',
                'author_name',
                'institution as institution_name',
                'keywords',
                'description',
                'purpose',
                'technology_readiness_level',
                DB::raw('image as image_path'),
                'document_path',
                'video_url',
                DB::raw("'opd' as author_role"),
                'created_at'
            )
            ->where('status', 'publication');

        // FILTER PENCARIAN
        if ($search) {
            $academicQuery->where('title', 'like', "%$search%");
            $opdQuery->where('title', 'like', "%$search%");
        }
        if ($categoryId) {
            $academicQuery->where('category', $categoryId);
            $opdQuery->where('category', $categoryId);
        }
        if ($subcategoryId) {
            $academicQuery->where(DB::raw('NULL'), $subcategoryId); // academic_innovations tidak punya subcategory
            $opdQuery->where('subcategory', $subcategoryId);
        }

        // UNION
        $unionSql = $academicQuery->unionAll($opdQuery);

        // Bungkus union agar bisa pakai orderBy
        $innovations = DB::table(DB::raw("({$unionSql->toSql()}) as innovations"))
            ->mergeBindings($unionSql)
            ->select('*');

        // FILTER TAMBAHAN & URUTAN
        if ($filter === 'Terbaru') {
            $innovations->orderBy('created_at', 'desc');
        } elseif ($filter === 'Terpopuler') {
            $innovations->orderBy('created_at', 'desc'); // Placeholder
        } elseif ($filter === 'Berkolaborasi' && Schema::hasTable('innovation_participants')) {
            $innovations->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('innovation_participants')
                    ->whereRaw('innovation_participants.innovation_id = innovations.id');
            })->orderBy('created_at', 'desc');
        } else {
            $innovations->orderBy('created_at', 'desc');
        }

        // PAGINATION MANUAL
        $page = $request->input('page', 1);
        $perPage = 12;
        $allInnovations = $innovations->get();
        $currentItems = $allInnovations->slice(($page - 1) * $perPage, $perPage)->values();
        $paginatedInnovations = new LengthAwarePaginator(
            $currentItems,
            $allInnovations->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // DATA FILTER
        $categories = Category::all();
        $subcategories = $categoryId
            ? Subcategory::where('category_id', $categoryId)->get()
            : collect();

        // STATISTIK
        $totalUsers = DB::table('users')->count();
        $totalInnovations =
            DB::table('academic_innovations')->where('status', 'publication')->count() +
            DB::table('opd_innovations')->where('status', 'publication')->count();
        $totalCollaborations = Schema::hasTable('innovation_participants')
            ? DB::table('innovation_participants')->count()
            : 0;

        // TOP USERS (berdasarkan komentar)
        $topUsers = collect();
        if (Schema::hasTable('discussion_comments') && Schema::hasTable('users')) {
            $topUsers = DB::table('discussion_comments')
                ->select('user_id', DB::raw('COUNT(*) as total_comments'))
                ->groupBy('user_id')
                ->orderByDesc('total_comments')
                ->limit(10)
                ->get()
                ->map(function ($u) {
                    $userData = DB::table('users')->where('id', $u->user_id)->first();
                    $u->name = $userData->name ?? 'Pengguna Tidak Dikenal';
                    $u->institution_name = $userData->institution_name ?? '-';
                    $u->avatar = $userData->avatar ?? null;
                    return $u;
                });
        }

        return view('diskusi.diskusi', compact(
            'paginatedInnovations', 'categories', 'subcategories',
            'totalUsers', 'totalInnovations', 'totalCollaborations',
            'categoryId', 'subcategoryId', 'filter', 'search', 'topUsers'
        ));
    }

    /**
     * Detail inovasi
     */
    public function detail($type, $id)
    {
        $table = $type === 'academic' ? 'academic_innovations' : 'opd_innovations';

        $innovation = DB::table($table)
            ->select(
                'id',
                'user_id',
                'title',
                DB::raw($table === 'academic_innovations' ? 'NULL as subcategory' : 'subcategory'),
                'category',
                'author_name',
                DB::raw('institution as institution_name'),
                'description',
                'technology_readiness_level',
                'image_path',
                'document_path',
                'video_url',
                'created_at',
                DB::raw("'" . $type . "' as author_role")
            )
            ->where('id', $id)
            ->first();

        if (!$innovation) abort(404);

        // Nama subkategori
        $subcategoryName = null;
        if ($innovation->subcategory && Schema::hasTable('subcategories')) {
            $sub = DB::table('subcategories')->where('id', $innovation->subcategory)->first();
            $subcategoryName = $sub ? $sub->name : null;
        }

        // Peserta
        $participants = Schema::hasTable('innovation_participants')
            ? DB::table('innovation_participants as ip')
                ->leftJoin('users as u', 'ip.user_id', '=', 'u.id')
                ->where('ip.innovation_id', $id)
                ->select('u.id', 'u.name', 'u.institution_name', 'u.avatar', 'ip.created_at as joined_at')
                ->get()
            : collect();

        // Komentar
        $comments = Schema::hasTable('discussion_comments')
            ? DB::table('discussion_comments as dc')
                ->leftJoin('users as u', 'dc.user_id', '=', 'u.id')
                ->where('dc.innovation_id', $id)
                ->orderBy('dc.created_at', 'asc')
                ->select(
                    'dc.id',
                    'dc.content',
                    'dc.created_at',
                    'u.id as user_id',
                    'u.name as user_name',
                    'u.institution_name as user_institution',
                    'u.role as user_role',
                    'u.avatar as user_avatar'
                )
                ->get()
            : collect();

        // Kolaborasi
        $collaborations = Schema::hasTable('collaboration_requests')
            ? DB::table('collaboration_requests as cr')
                ->leftJoin('users as u', 'cr.user_id', '=', 'u.id')
                ->where('cr.innovation_id', $id)
                ->orderBy('cr.created_at', 'desc')
                ->select(
                    'cr.id',
                    'cr.user_id',
                    'cr.message',
                    'cr.status',
                    'cr.created_at',
                    'u.name as user_name',
                    'u.institution_name as user_institution',
                    'u.avatar as user_avatar'
                )
                ->get()
            : collect();

        // Pengajuan kolaborasi milik user login
        $myCollaboration = null;
        if (Auth::check() && Schema::hasTable('collaboration_requests')) {
            $myCollaboration = DB::table('collaboration_requests')
                ->where('innovation_id', $id)
                ->where('user_id', Auth::id())
                ->first();
        }

        // Pending kolaborasi untuk owner
        $pendingForOwner = null;
        if (Schema::hasTable('collaboration_requests')) {
            $pendingForOwner = DB::table('collaboration_requests as cr')
                ->leftJoin('users as u', 'cr.user_id', '=', 'u.id')
                ->where('cr.innovation_id', $id)
                ->where('cr.status', 'pending')
                ->select('cr.*', 'u.name as user_name', 'u.institution_name as user_institution', 'u.avatar as user_avatar')
                ->first();
        }

        return view('diskusi.diskusi-detail', [
            'innovation' => (object) array_merge((array) $innovation, ['subcategory_name' => $subcategoryName]),
            'participants' => $participants,
            'comments' => $comments,
            'collaborations' => $collaborations,
            'myCollaboration' => $myCollaboration,
            'pendingForOwner' => $pendingForOwner,
            'type' => $type
        ]);
    }

    /**
     * Tambah komentar
     */
    public function addComment(Request $request, $type, $id)
    {
        $request->validate(['content' => 'required|string|max:2000']);
        if (!Auth::check()) return back()->with('error', 'Silakan login terlebih dahulu.');
        if (!Schema::hasTable('discussion_comments')) return back()->with('error', 'Tabel komentar belum dibuat.');

        DB::table('discussion_comments')->insert([
            'innovation_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Ambil subkategori (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->query('category');
        if (!$categoryId) return response()->json([]);
        $subcategories = Subcategory::where('category_id', $categoryId)->get(['id', 'name']);
        return response()->json($subcategories);
    }
}
