<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolusiController extends Controller
{
    public function index()
    {
        return view('pemerintah.solusi');
    }
}