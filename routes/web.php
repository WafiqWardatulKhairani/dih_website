<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\Akademisi\InnovationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\Pemerintah\DiskusiController;
use App\Http\Controllers\Pemerintah\KolaborasiController;
use App\Http\Controllers\Pemerintah\ProgramController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Auth\UserRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// =============== LANDING PAGE & PUBLIC ROUTES ===============
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/tentang', [LandingPageController::class, 'tentang'])->name('tentang');

// Public routes untuk program & inovasi (VIEW ONLY)
// Public routes untuk program & inovasi (VIEW ONLY)
Route::prefix('program-inovasi')->name('program.')->group(function () {
    Route::get('/', [ProgramController::class, 'programInnovationIndex'])->name('innovation.index');
    Route::get('/program', [ProgramController::class, 'showPrograms'])->name('list');
    Route::get('/inovasi', [ProgramController::class, 'showInnovations'])->name('innovation.list');

    // ✅ ROUTE DETAIL BARU
    Route::get('/program/{id}', [ProgramController::class, 'showProgramDetail'])->name('detail');
    Route::get('/inovasi/{id}', [ProgramController::class, 'showInnovationDetail'])->name('innovation.detail');
});

// Redirect routes
Route::redirect('/innovation-hub', '/')->name('innovation.hub');
Route::redirect('/home', '/')->name('home');
Route::redirect('/register', '/daftar')->name('register');

// =============== GUEST ROUTES ===============
Route::middleware('guest')->group(function () {
    Route::get('/daftar', UserRegister::class)->name('user.register');
});

// =============== AUTHENTICATED ROUTES ===============
Route::middleware('auth')->group(function () {

    // =============== PEMERINTAH ROUTES ===============
    Route::prefix('pemerintah')->name('pemerintah.')->group(function () {
        Route::get('/', [PemerintahController::class, 'index'])->name('index');
        Route::get('/program', [ProgramController::class, 'programPage'])->name('program');
        Route::get('/kolaborasi', [KolaborasiController::class, 'index'])->name('kolaborasi');
        Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi');
        Route::get('/proyek', [PemerintahController::class, 'proyek'])->name('proyek');
        Route::get('/laporan', [PemerintahController::class, 'laporan'])->name('laporan');
        Route::get('/pengaturan', [PemerintahController::class, 'pengaturan'])->name('pengaturan');
        // ✅ PERBAIKAN: CRUD Program Pemerintah dengan nama route yang benar
        Route::prefix('program')->name('program.')->group(function () {
            Route::get('/create', [ProgramController::class, 'createProgram'])->name('create');
            Route::post('/store', [ProgramController::class, 'storeProgram'])->name('store');
            Route::get('/edit/{id}', [ProgramController::class, 'editProgram'])->name('edit');
            Route::put('/update/{id}', [ProgramController::class, 'updateProgram'])->name('update');
            Route::delete('/delete/{id}', [ProgramController::class, 'destroyProgram'])->name('destroy');
        });
        // ✅ PERBAIKAN: CRUD Inovasi Pemerintah dengan nama route yang benar
        Route::prefix('inovasi')->name('inovasi.')->group(function () {
            Route::get('/create', [ProgramController::class, 'createInnovation'])->name('create');
            Route::post('/store', [ProgramController::class, 'storeInnovation'])->name('store');
            Route::get('/edit/{id}', [ProgramController::class, 'editInnovation'])->name('edit');
            Route::put('/update/{id}', [ProgramController::class, 'updateInnovation'])->name('update');
            Route::delete('/delete/{id}', [ProgramController::class, 'destroyInnovation'])->name('destroy');
        });
    });
// =============== AKADEMISI ROUTES ===============
Route::prefix('akademisi')->name('akademisi.')->middleware(['auth'])->group(function () {

    // Halaman utama akademisi
    Route::get('/', [AkademisiController::class, 'index'])->name('index');

    // ---------- Inovasi ----------
    Route::prefix('inovasi')->name('inovasi.')->group(function () {

        // Route AJAX Subkategori (harus sebelum route {innovation})
        Route::get('/subcategories', [InnovationController::class, 'subcategories'])
            ->name('subcategories');

        // CRUD inovasi
        Route::get('/', [InnovationController::class, 'index'])->name('index');
        Route::get('/create', [InnovationController::class, 'create'])->name('create');
        Route::post('/', [InnovationController::class, 'store'])->name('store'); // RESTful: store ke "/"
        Route::get('/{innovation}', [InnovationController::class, 'show'])->name('show');
        Route::get('/{innovation}/edit', [InnovationController::class, 'edit'])->name('edit');
        Route::put('/{innovation}', [InnovationController::class, 'update'])->name('update');
        Route::delete('/{innovation}', [InnovationController::class, 'destroy'])->name('destroy');

    });

    // ---------- Menu Lain ----------
    Route::get('/proyek-saya', [AkademisiController::class, 'proyekSaya'])->name('proyek-saya');
    Route::get('/kolaborasi', [AkademisiController::class, 'kolaborasi'])->name('kolaborasi');
    Route::get('/profil-akademik', [AkademisiController::class, 'profilAkademik'])->name('profil-akademik');
    Route::get('/notifikasi', [AkademisiController::class, 'notifikasi'])->name('notifikasi');

});

// =============== PROFILE ROUTES ===============
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // =============== DASHBOARD REDIRECT ===============
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'pemerintah' => redirect()->route('pemerintah.index'),
            'akademisi'  => redirect()->route('akademisi.index'),
            'admin'      => redirect()->route('admin.index'),
            default      => redirect()->route('landing-page'),
        };
    })->name('dashboard');

    // =============== USER STATUS API ===============
    Route::get('/user/status', function () {
        $user = Auth::user();
        return response()->json([
            'status' => $user ? $user->status : null,
        ]);
    })->name('user.status');
});

// =============== ADMIN ROUTES ===============
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'createUser'])->name('create');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyUser'])->name('destroy');
            Route::post('/{id}/verify', [AdminController::class, 'verify'])->name('verify');
            Route::delete('/{id}/reject', [AdminController::class, 'reject'])->name('reject');
        });

        // Menu Admin Lainnya
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');
        Route::get('/moderasi-konten', [AdminController::class, 'moderasiKonten'])->name('moderasi-konten');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
        Route::get('/pengaturan-sistem', [AdminController::class, 'pengaturanSistem'])->name('pengaturan-sistem');
    });

// =============== LOGOUT ROUTE ===============
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// =============== FALLBACK ROUTE ===============
Route::fallback(fn() => redirect()->route('landing-page'));
