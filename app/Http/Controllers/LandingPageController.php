<?php
namespace App\Http\Controllers;

use App\Models\Program; // Pastikan model Program ada
use App\Models\ProgramPemerintah;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data programs dari database
        $programs = ProgramPemerintah::take(6)->get(); // Ambil 6 program terbaru

        return view('landing.landing_page', compact('programs'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }
}