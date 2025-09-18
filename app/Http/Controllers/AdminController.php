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
}
