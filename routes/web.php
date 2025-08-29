<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Akademisi\PostInnovationController;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

// Halaman Pemerintah
Route::get('/pemerintah', [PemerintahController::class, 'index'])->name('pemerintah.index');

// Halaman Akademisi (beranda akademisi)
Route::get('/akademisi', [AkademisiController::class, 'index'])->name('akademisi.index');

// Halaman Innovation Hub (opsional jika berbeda dengan landing page)
Route::get('/innovation-hub', [LandingPageController::class, 'index'])->name('innovation.hub');

// Halaman posting inovasi untuk akademisi
Route::prefix('akademisi')->name('akademisi.')->group(function () {
    Route::get('/post-inovasi', [PostInnovationController::class, 'create'])
        ->name('post_inovasi.create');

    Route::post('/post-inovasi', [PostInnovationController::class, 'store'])
        ->name('post_inovasi.store');

    Route::get('/innovation/{innovation}', [PostInnovationController::class, 'show'])
        ->name('post_inovasi.show');
        // Halaman Akademisi (beranda akademisi)
Route::get('/akademisi', [AkademisiController::class, 'index'])->name('akademisi.index');

// Alias/URL tambahan agar sesuai dengan nama route di navbar
Route::get('/akademisi/beranda', [AkademisiController::class, 'index'])
    ->name('akademisi.index.create');
});
