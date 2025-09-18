<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Akademisi\PostInnovationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pemerintah\ProgramController;

// Livewire Components
use App\Livewire\Auth\UserRegister;
use App\Livewire\Auth\UserLogin;

// Auth routes bawaan Breeze
require __DIR__ . '/auth.php';

// ================== LANDING PAGE ==================
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::redirect('/innovation-hub', '/')->name('innovation.hub');

// ================== GUEST ==================
Route::middleware('guest')->group(function () {
    Route::get('/daftar', UserRegister::class)->name('user.register');
    Route::get('/register', fn () => redirect()->route('user.register'))->name('register');
    Route::get('/login', UserLogin::class)->name('login');
});

// ================== PUBLIC ==================
Route::get('/programs', [ProgramController::class, 'list'])->name('program.list');

// ================== AUTHENTICATED USERS ==================
Route::middleware('auth')->group(function () {

    // Pemerintah
    Route::get('/pemerintah', [PemerintahController::class, 'index'])->name('pemerintah.index');

    // Akademisi
    Route::prefix('akademisi')->name('akademisi.')->group(function () {
        Route::get('/', [AkademisiController::class, 'index'])->name('index');
        Route::get('/post-inovasi', [PostInnovationController::class, 'create'])->name('post-inovasi.create');
        Route::post('/post-inovasi', [PostInnovationController::class, 'store'])->name('post-inovasi.store');
        Route::get('/innovation/{innovation}', [PostInnovationController::class, 'show'])->name('post-inovasi.show');
    });

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// ================== ADMIN ==================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/verify', [AdminController::class, 'verify'])->name('users.verify');
    });
