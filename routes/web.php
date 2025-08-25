<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/pemerintah', [PemerintahController::class, 'index'])->name('pemerintah.index');
Route::get('/akademisi', [AkademisiController::class, 'index'])->name('akademisi.index');


