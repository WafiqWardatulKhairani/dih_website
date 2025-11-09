<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemerintahController extends Controller
{
    public function index()
    {
        return view('pemerintah.index');
    }

}
