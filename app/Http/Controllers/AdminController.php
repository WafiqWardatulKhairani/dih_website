<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // list user
    public function index()
    {
        $users = User::all();

        $totalUsers      = User::count();
        $pemerintahCount = User::where('role', 'pemerintah')->count();
        $akademisiCount  = User::where('role', 'akademisi')->count();
        $pendingCount    = User::where('status', 'pending')->count();
        $recentUsers     = User::latest()->take(5)->get(); // ➜ tambahkan ini

        return view('admin.index', compact(
            'users',
            'totalUsers',
            'pemerintahCount',
            'akademisiCount',
            'pendingCount',
            'recentUsers'      // ➜ jangan lupa kirim ke view
        ));
    }
    // verifikasi user
    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'verified';
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diverifikasi!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);

        // Tandai status ditolak (opsional kalau tetap mau simpan record)
        $user->status = 'rejected';
        $user->save();

        // 🔑 Hapus semua session milik user ini
        DB::table('sessions')->where('user_id', $user->id)->delete();

        // ➜ kalau mau benar-benar hapus akun dari database, bisa juga:
        // $user->delete();

        // (opsional) kirim notifikasi/email ke user
        // Mail::to($user->email)->send(new AccountRejectedMail($user));

        return back()->with('success', 'User berhasil ditolak dan otomatis logout.');
    }


    public function usersIndex()
    {
        $users = User::all(); // Pastikan model User di-import
        return view('admin.users.index', compact('users'));
    }

    public function moderasiKonten()
    {
        return view('admin.moderasi-konten');
    }

    public function statistik()
{
    $stats = [
        'totalUsers' => User::count(),
        'pemerintahCount' => User::where('role', 'pemerintah')->count(),
        'akademisiCount' => User::where('role', 'akademisi')->count(),
        'verifiedCount' => User::whereNotNull('email_verified_at')->count()
    ];

    return view('admin.statistik', $stats);
}

    public function pengaturanSistem()
    {
        return view('admin.pengaturan-sistem');
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        // Logic untuk menyimpan user baru
    }

    public function editUser($id)
    {
        return view('admin.users.edit', compact('id'));
    }

    public function updateUser(Request $request, $id)
    {
        // Logic untuk update user
    }

    public function destroyUser($id)
    {
        // Logic untuk hapus user
    }
}
