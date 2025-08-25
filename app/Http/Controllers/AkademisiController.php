<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkademisiController extends Controller
{
    public function index()
    {
        // Tampilkan view resources/views/akademisi/index.blade.php
        return view('akademisi.index');
    }
}
