<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use App\Models\ProgramPemerintah;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = ProgramPemerintah::latest()->take(6)->get();
        return view('landing.landing_page', compact('programs'));
    }
    
    public function programPage()
    {
        $programs = ProgramPemerintah::latest()->paginate(9);
        return view('pemerintah.program', compact('programs'));
    }
}