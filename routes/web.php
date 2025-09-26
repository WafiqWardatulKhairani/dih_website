<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\Akademisi\InnovationController;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\Pemerintah\ProgramController;
use App\Http\Controllers\Pemerintah\SolusiController;
use App\Http\Controllers\Pemerintah\InkubasiController;
use App\Http\Controllers\Pemerintah\DiskusiController;
use App\Livewire\Auth\UserRegister;
use App\Livewire\Auth\UserLogin;

require __DIR__ . '/auth.php';

// =============== LANDING PAGE ===============
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/tentang', [LandingPageController::class, 'tentang'])->name('tentang');
Route::redirect('/innovation-hub', '/')->name('innovation.hub');
Route::redirect('/home', '/')->name('home');

// =============== GUEST ======================
Route::middleware('guest')->group(function () {
    Route::get('/daftar', UserRegister::class)->name('user.register');
    Route::get('/register', fn() => redirect()->route('user.register'))->name('register');
    Route::get('/login', UserLogin::class)->name('login');
});

// =============== PUBLIC =====================
Route::get('/programs', [ProgramController::class, 'list'])->name('program.list');

// =============== PEMERINTAH ==================
Route::prefix('pemerintah')->name('pemerintah.')->group(function () {
    Route::get('/', [PemerintahController::class, 'index'])->name('index');
    Route::get('/program', [ProgramController::class, 'programPage'])->name('program');
    Route::get('/solusi', [SolusiController::class, 'index'])->name('solusi');
    Route::get('/inkubasi', [InkubasiController::class, 'index'])->name('inkubasi');
    Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi');
    Route::get('/proyek', [PemerintahController::class, 'proyek'])->name('proyek');
    Route::get('/laporan', [PemerintahController::class, 'laporan'])->name('laporan');
    Route::get('/pengaturan', [PemerintahController::class, 'pengaturan'])->name('pengaturan');
});

// =============== AUTH USERS ==================
Route::middleware('auth')->group(function () {
    // Akademisi
    Route::prefix('akademisi')->name('akademisi.')->group(function () {
        Route::get('/', [AkademisiController::class, 'index'])->name('index');
        
        // Routes untuk inovasi
        Route::prefix('inovasi')->name('inovasi.')->group(function () {
            // Create
            Route::get('/create', [InnovationController::class, 'create'])->name('create');
            Route::post('/store', [InnovationController::class, 'store'])->name('store');
            
            // Read
            Route::get('/{id}', [InnovationController::class, 'show'])->name('show');
            
            // Update
            Route::get('/{id}/edit', [InnovationController::class, 'edit'])->name('edit');
            Route::put('/{id}', [InnovationController::class, 'update'])->name('update');
            
            // Delete (jika diperlukan)
            // Route::delete('/{id}', [InnovationController::class, 'destroy'])->name('destroy');
        });
        
        // Ajax subcategories
        Route::get('/subcategories', [InnovationController::class, 'subcategories'])->name('subcategories');

        // Menu lainnya
        Route::get('/proyek-saya', [AkademisiController::class, 'proyekSaya'])->name('proyek-saya');
        Route::get('/kolaborasi', [AkademisiController::class, 'kolaborasi'])->name('kolaborasi');
        Route::get('/profil-akademik', [AkademisiController::class, 'profilAkademik'])->name('profil-akademik');
        Route::get('/notifikasi', [AkademisiController::class, 'notifikasi'])->name('notifikasi');
    });
    
    // Dashboard role-based
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'pemerintah' => redirect()->route('pemerintah.index'),
            'akademisi'  => redirect()->route('akademisi.index'),
            'admin'      => redirect()->route('admin.index'),
            default      => redirect()->route('landing-page'),
        };
    })->name('dashboard');

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// =============== ADMIN =======================
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Route untuk manajemen user - GUNAKAN usersIndex() BUKAN manajemenUser()
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::post('/users/{id}/verify', [AdminController::class, 'verify'])->name('users.verify');
        Route::delete('/users/{id}/reject', [AdminController::class, 'reject'])->name('users.reject');


        // Route lainnya (jika masih diperlukan)
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');
        Route::get('/moderasi-konten', [AdminController::class, 'moderasiKonten'])->name('moderasi-konten');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
        Route::get('/pengaturan-sistem', [AdminController::class, 'pengaturanSistem'])->name('pengaturan-sistem');

        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

// routes/web.php
Route::get('/user/status', function () {
    $user = Auth::user();
    return response()->json([
        'status' => $user ? $user->status : null,
    ]);
})->middleware('auth')->name('user.status');


// =============== FALLBACK ====================
Route::fallback(fn() => redirect()->route('landing-page'));