<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // list user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // verifikasi user
    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'verified';
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diverifikasi!');
    }

    public function manajemenUser()
{
    return view('admin.manajemen-user');
}

public function moderasiKonten()
{
    return view('admin.moderasi-konten');
}

public function statistik()
{
    return view('admin.statistik');
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
