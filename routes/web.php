<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;


Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');


Route::get('/pemerintah', function () {
    return view('pemerintah.index');
})->name('pemerintah');

Route::get('/akademisi', function () {
    return view('akademisi.index');
})->name('akademisi');

