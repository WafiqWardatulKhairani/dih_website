<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\Akademisi\PostInnovationController;
use App\Http\Controllers\ProfileController;

// Controller Pemerintah
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\Pemerintah\ProgramController;
use App\Http\Controllers\Pemerintah\SolusiController;
use App\Http\Controllers\Pemerintah\InkubasiController;
use App\Http\Controllers\Pemerintah\DiskusiController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Livewire Components
use App\Livewire\LandingPage;
use App\Livewire\Auth\UserRegister;
use App\Livewire\Auth\UserLogin;

// Auth routes bawaan Breeze
require __DIR__ . '/auth.php';

// ================== LANDING PAGE ==================
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/tentang', [LandingPageController::class, 'tentang'])->name('tentang');
Route::redirect('/innovation-hub', '/')->name('innovation.hub');
Route::redirect('/home', '/')->name('home'); // Route home untuk navigasi

// ================== GUEST ==================
Route::middleware('guest')->group(function () {
    Route::get('/daftar', UserRegister::class)->name('user.register');
    Route::get('/register', fn () => redirect()->route('user.register'))->name('register');
    Route::get('/login', UserLogin::class)->name('login');
});

// ================== PUBLIC ==================
Route::get('/programs', [ProgramController::class, 'list'])->name('program.list');

// ================== PEMERINTAH ROUTES ==================
Route::prefix('pemerintah')->name('pemerintah.')->group(function () {
    // Halaman utama pemerintah
    Route::get('/', [PemerintahController::class, 'index'])->name('index');
    
    // Program
    Route::get('/program', [ProgramController::class, 'programPage'])->name('program');
    
    // Solusi
    Route::get('/solusi', [SolusiController::class, 'index'])->name('solusi');
    
    // Inkubasi
    Route::get('/inkubasi', [InkubasiController::class, 'index'])->name('inkubasi');
    
    // Diskusi
    Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi');
    
    // Route tambahan untuk pemerintah
    Route::get('/proyek', [PemerintahController::class, 'proyek'])->name('proyek');
    Route::get('/laporan', [PemerintahController::class, 'laporan'])->name('laporan');
    Route::get('/pengaturan', [PemerintahController::class, 'pengaturan'])->name('pengaturan');
});

// ================== AUTHENTICATED USERS ==================
Route::middleware('auth')->group(function () {
    // Akademisi
    Route::prefix('akademisi')->name('akademisi.')->group(function () {
        Route::get('/', [AkademisiController::class, 'index'])->name('index');
        Route::get('/post-inovasi', [PostInnovationController::class, 'create'])->name('post-inovasi.create');
        Route::post('/post-inovasi', [PostInnovationController::class, 'store'])->name('post-inovasi.store');
        Route::get('/innovation/{innovation}', [PostInnovationController::class, 'show'])->name('post-inovasi.show');
        
        // Route tambahan untuk akademisi
        Route::get('/proyek-saya', [AkademisiController::class, 'proyekSaya'])->name('proyek-saya');
        Route::get('/kolaborasi', [AkademisiController::class, 'kolaborasi'])->name('kolaborasi');
        Route::get('/profil-akademik', [AkademisiController::class, 'profilAkademik'])->name('profil-akademik');
        Route::get('/notifikasi', [AkademisiController::class, 'notifikasi'])->name('notifikasi');
    });

    // Route untuk semua user terautentikasi
    Route::get('/dashboard', function () {
        return match(auth()->user()->role) {
            'pemerintah' => redirect()->route('pemerintah.index'),
            'akademisi' => redirect()->route('akademisi.index'),
            'admin' => redirect()->route('admin.users.index'),
            default => redirect()->route('landing-page'),
        };
    })->name('dashboard');

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

// ================== ADMIN ==================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/verify', [AdminController::class, 'verify'])->name('users.verify');
        
        // Route tambahan untuk admin
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');
        Route::get('/moderasi-konten', [AdminController::class, 'moderasiKonten'])->name('moderasi-konten');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
        Route::get('/pengaturan-sistem', [AdminController::class, 'pengaturanSistem'])->name('pengaturan-sistem');
        
        // CRUD operations
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

// ================== FALLBACK ROUTE ==================
Route::fallback(function () {
    return redirect()->route('landing-page');
});