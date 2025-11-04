<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

// ===== CONTROLLERS =====
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// ===== AKADEMISI & PEMERINTAH =====
use App\Http\Controllers\AkademisiController;
use App\Http\Controllers\Akademisi\DashboardController as AkademisiDashboardController;
use App\Http\Controllers\Akademisi\InnovationController;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\Pemerintah\DashboardController as PemerintahDashboardController;
use App\Http\Controllers\Pemerintah\ProgramController;

// ===== KOLABORASI (UNIVERSAL) =====
use App\Http\Controllers\Kolaborasi\KolaborasiController;
use App\Http\Controllers\Kolaborasi\IdeController;
use App\Http\Controllers\Kolaborasi\MemberController;
use App\Http\Controllers\Kolaborasi\TaskController;
use App\Http\Controllers\Kolaborasi\ProgressController;
use App\Http\Controllers\Kolaborasi\DocumentController;
use App\Http\Controllers\Kolaborasi\ReviewController;
use App\Http\Controllers\Kolaborasi\RequestController;

// ===== DISKUSI =====
use App\Http\Controllers\DiskusiController;

// ===== LIVEWIRE =====
use App\Livewire\Auth\UserRegister;

// ========================================================
// =============== LANDING PAGE & PUBLIC ==================
// ========================================================
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/tentang', [LandingPageController::class, 'tentang'])->name('tentang');

Route::prefix('program-inovasi')->name('program.')->group(function () {
    Route::get('/', [ProgramController::class, 'programInnovationIndex'])->name('innovation.index');
    Route::get('/program', [ProgramController::class, 'showPrograms'])->name('list');
    Route::get('/inovasi', [ProgramController::class, 'showInnovations'])->name('innovation.list');
    Route::get('/program/{id}', [ProgramController::class, 'showProgramDetail'])->name('detail');
    Route::get('/inovasi/{id}', [ProgramController::class, 'showInnovationDetail'])->name('innovation.detail');
});

// ========================================================
// ================= FORUM DISKUSI ========================
// ========================================================
Route::prefix('forum-diskusi')->name('forum-diskusi.')->group(function () {

    // ----------------------
    // Halaman utama forum
    // ----------------------
    Route::get('/', [DiskusiController::class, 'index'])->name('index');

    // Pencarian forum
    Route::get('/search', [DiskusiController::class, 'search'])->name('search');

    // AJAX: Ambil subkategori
    Route::get('/ajax-subcategories', [DiskusiController::class, 'getSubcategories'])
        ->name('ajax-subcategories');

    // ===================== ROUTE AUTHENTICATED =====================
    Route::middleware('auth')->group(function () {

        // ----------------------
        // Tambah komentar (POST)
        // ----------------------
        // Letakkan POST sebelum GET detail supaya tidak tertangkap GET route
        Route::post('/{type}/{id}/comment', [DiskusiController::class, 'addComment'])
            ->where([
                'id' => '[0-9]+',
                'type' => '(academic|opd|innovation)'
            ])
            ->name('add-comment');

        // ----------------------
        // Hapus komentar (DELETE)
        // ----------------------
        Route::delete('/delete-comment/{id}', [DiskusiController::class, 'deleteComment'])
            ->where('id', '[0-9]+')
            ->name('delete-comment');

        // ----------------------
        // Ajukan kolaborasi (POST)
        // ----------------------
        Route::post('/{type}/{id}/propose-collaboration', [DiskusiController::class, 'proposeCollaboration'])
            ->where([
                'id' => '[0-9]+',
                'type' => '(academic|opd|innovation)'
            ])
            ->name('propose-collaboration');

        // ----------------------
        // Detail diskusi / inovasi (GET)
        // ----------------------
        // Letakkan GET detail terakhir supaya route POST tidak tertangkap
        Route::get('/{type}/{id}', [DiskusiController::class, 'detail'])
            ->where([
                'id' => '[0-9]+',
                'type' => '(academic|opd|innovation)'
            ])
            ->name('detail');
    });
});

// ========================================================
// =============== AUTH ROUTES ============================
// ========================================================

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/daftar', UserRegister::class)->name('user.register');

    // Password Reset
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Redirects
Route::redirect('/innovation-hub', '/')->name('innovation.hub');
Route::redirect('/home', '/')->name('home');
Route::redirect('/register', '/daftar')->name('register');

// ========================================================
// =============== AUTHENTICATED ROUTES ===================
// ========================================================
Route::middleware('auth')->group(function () {

// ============================================================
// 🌐 ROUTE KOLABORASI (PUBLIC + PRIVATE)
// ============================================================

// ============================================================
// 🔹 ROUTE PUBLIK — Bisa diakses tanpa login
// ============================================================
Route::prefix('kolaborasi')
    ->name('kolaborasi.')
    ->group(function () {
        Route::get('/', [KolaborasiController::class, 'index'])->name('index');             // List kolaborasi
        Route::get('/{id}/detail', [KolaborasiController::class, 'detail'])->name('detail'); // Halaman detail kolaborasi
        Route::get('/search', [KolaborasiController::class, 'search'])->name('search');     // Search kolaborasi
    });

// ============================================================
// 🔹 ROUTE PRIVATE — Hanya bisa diakses setelah login
// ============================================================
Route::prefix('kolaborasi')
    ->name('kolaborasi.')
    ->middleware(['auth'])
    ->group(function () {

        // ============================================================
        // 🔹 IDE KOLABORASI
        // ============================================================
        Route::prefix('ide')
            ->name('ide.')
            ->controller(IdeController::class)
            ->group(function () {
                Route::get('/create', 'create')->name('create');                        // Form ide baru
                Route::post('/', 'store')->name('store');                                // Simpan ide baru
                Route::get('/{id}', 'show')->name('show');                               // Detail ide
                Route::get('/{id}/edit', 'edit')->name('edit');                          // Form edit ide
                Route::put('/{id}', 'update')->name('update');                            // Update ide
                Route::delete('/{id}', 'destroy')->name('destroy');                       // Hapus ide
                Route::post('/{id}/vote', 'vote')->name('vote');                          // Voting ide
                Route::post('/{id}/approve-ajax', 'approveAjax')->name('approve_ajax');   // Approve ide via AJAX
                Route::post('/{id}/join', 'join')->name('join');                          // Join kolaborasi
            });

        // ============================================================
        // 🔹 MEMBER KOLABORASI
        // ============================================================
        Route::prefix('members')
            ->name('members.')
            ->controller(MemberController::class)
            ->group(function () {
                Route::get('/{kolaborasi}', 'index')->name('index');                       // Daftar anggota kolaborasi
                Route::post('/{kolaborasi}/add', 'store')->name('store');                  // Tambah anggota baru
                Route::post('/{kolaborasi}/{member}/approve', 'approve')->name('approve'); // Approve anggota
                Route::delete('/{kolaborasi}/{user}', 'destroy')->name('destroy');         // Hapus anggota
            });

        // ============================================================
        // 🔹 TASK / TUGAS KOLABORASI
        // ============================================================
        Route::prefix('tasks')
            ->name('tasks.')
            ->controller(TaskController::class)
            ->group(function () {
                Route::get('/{kolaborasi}', 'index')->name('index');       // Daftar tugas
                Route::post('/{kolaborasi}', 'store')->name('store');       // Tambah tugas
                Route::put('/{id}', 'update')->name('update');              // Update tugas
                Route::delete('/{id}', 'destroy')->name('destroy');         // Hapus tugas
            });

        // ============================================================
        // 🔹 PROGRESS KOLABORASI
        // ============================================================
        Route::prefix('progress')
            ->name('progress.')
            ->controller(ProgressController::class)
            ->group(function () {
                Route::get('/{kolaborasi}', 'index')->name('index');         // Halaman progress
                Route::post('/{kolaborasi}', 'store')->name('store');        // Tambah progress baru
                Route::delete('/{progress}', 'destroy')->name('destroy');    // Hapus progress
                Route::patch('/{progress}', 'update')->name('update');       // Update progress inline
            });

        // ============================================================
        // 🔹 DOKUMEN KOLABORASI
        // ============================================================
        Route::prefix('documents')
            ->name('documents.')
            ->controller(DocumentController::class)
            ->group(function () {
                Route::get('/{kolaborasi}', 'index')->name('index');                  // List dokumen
                Route::post('/{kolaborasi}/upload', 'store')->name('store');          // Upload dokumen
                Route::delete('/{id}', 'destroy')->name('destroy');                    // Hapus dokumen
            });

        // ============================================================
        // 🔹 REVIEW KOLABORASI
        // ============================================================
        Route::prefix('reviews')
            ->name('reviews.')
            ->controller(ReviewController::class)
            ->group(function () {
                Route::get('/{kolaborasi}', 'index')->name('index');                  // Halaman review
                Route::post('/{kolaborasi}', 'store')->name('store');                 // Simpan review baru
                Route::put('/{review_id}', 'update')->name('update');                 // Update review (PUT)
                Route::patch('/{review_id}', 'update-patch')->name('update-patch');  // Update review (PATCH)
                Route::delete('/{review_id}', 'destroy')->name('destroy');            // Hapus review
                Route::patch('/{review_id}/rating', 'updateRating')->name('updateRating');       // AJAX rating
                Route::patch('/{review_id}/komentar', 'updateKomentar')->name('updateKomentar'); // AJAX komentar
            });

        // ============================================================
        // 🔹 REQUEST (Permintaan Gabung / Undangan)
        // ============================================================
        Route::prefix('requests')
            ->name('requests.')
            ->controller(RequestController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');                               // Daftar request
                Route::post('/{kolaborasi}', 'store')->name('store');                  // Kirim request join
                Route::post('/{kolaborasi}/{id}/approve', 'approve')->name('approve'); // Approve request
                Route::post('/{kolaborasi}/{id}/reject', 'reject')->name('reject');    // Reject request
                Route::delete('/{kolaborasi}/{id}', 'destroy')->name('destroy');       // Hapus request
            });
    });

    // ============================================================
    // 🔹 PEMERINTAH ROUTES
    // ============================================================
    Route::prefix('pemerintah')->name('pemerintah.')->group(function () {
Route::get('/', [PemerintahDashboardController::class, 'index'])->name('index');
Route::get('/dashboard', [PemerintahDashboardController::class, 'index'])->name('dashboard');
Route::get('/api/dashboard/chart-data', [PemerintahDashboardController::class, 'getChartData'])->name('dashboard.chart-data');
        Route::get('/kolaborasi', fn() => redirect()->route('kolaborasi.ide.index'))->name('kolaborasi');
        Route::get('/program', [ProgramController::class, 'programPage'])->name('program');

        Route::prefix('program')->name('program.')->group(function () {
            Route::get('/create', [ProgramController::class, 'createProgram'])->name('create');
            Route::post('/store', [ProgramController::class, 'storeProgram'])->name('store');
            Route::get('/edit/{id}', [ProgramController::class, 'editProgram'])->name('edit');
            Route::put('/update/{id}', [ProgramController::class, 'updateProgram'])->name('update');
            Route::delete('/delete/{id}', [ProgramController::class, 'destroyProgram'])->name('destroy');
        });

        Route::prefix('inovasi')->name('inovasi.')->group(function () {
            Route::get('/create', [ProgramController::class, 'createInnovation'])->name('create');
            Route::post('/store', [ProgramController::class, 'storeInnovation'])->name('store');
            Route::get('/edit/{id}', [ProgramController::class, 'editInnovation'])->name('edit');
            Route::put('/update/{id}', [ProgramController::class, 'updateInnovation'])->name('update');
            Route::delete('/delete/{id}', [ProgramController::class, 'destroyInnovation'])->name('destroy');
        });

        Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi');
        Route::get('/proyek', [PemerintahController::class, 'proyek'])->name('proyek');
        Route::get('/laporan', [PemerintahController::class, 'laporan'])->name('laporan');
        Route::get('/pengaturan', [PemerintahController::class, 'pengaturan'])->name('pengaturan');
    });

    // ============================================================
    // 🔹 AKADEMISI ROUTES
    // ============================================================
    Route::prefix('akademisi')->name('akademisi.')->group(function () {
    // ===================== DASHBOARD =====================
    Route::get('/', [AkademisiDashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [AkademisiDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('inovasi')->name('inovasi.')->group(function () {
            Route::get('/subcategories', [InnovationController::class, 'subcategories'])->name('subcategories');
            Route::get('/', [InnovationController::class, 'index'])->name('index');
            Route::get('/create', [InnovationController::class, 'create'])->name('create');
            Route::post('/', [InnovationController::class, 'store'])->name('store');
            Route::get('/{innovation}', [InnovationController::class, 'show'])->name('show');
            Route::get('/{innovation}/edit', [InnovationController::class, 'edit'])->name('edit');
            Route::put('/{innovation}', [InnovationController::class, 'update'])->name('update');
            Route::delete('/{innovation}', [InnovationController::class, 'destroy'])->name('destroy');
        });

        Route::get('/kolaborasi', fn() => redirect()->route('kolaborasi.ide.index'))->name('kolaborasi.index');
        Route::get('/proyek-saya', [AkademisiController::class, 'proyekSaya'])->name('proyek-saya');
        Route::get('/profil-akademik', [AkademisiController::class, 'profilAkademik'])->name('profil-akademik');
        Route::get('/notifikasi', [AkademisiController::class, 'notifikasi'])->name('notifikasi');
    });

    // ============================================================
    // 🔹 PROFILE & DASHBOARD REDIRECT
    // ============================================================
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'pemerintah' => redirect()->route('pemerintah.dashboard'),
            'akademisi'  => redirect()->route('akademisi.dashboard'),
            'admin'      => redirect()->route('admin.index'),
            default      => redirect()->route('landing-page'),
        };
    })->name('dashboard');

    Route::get('/user/status', fn() => response()->json(['status' => Auth::user()?->status]))->name('user.status');
});

// ========================================================
// =============== ADMIN ROUTES ===========================
// ========================================================
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

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

        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');
        Route::get('/moderasi-konten', [AdminController::class, 'moderasiKonten'])->name('moderasi-konten');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
        Route::get('/pengaturan-sistem', [AdminController::class, 'pengaturanSistem'])->name('pengaturan-sistem');
    });

// ========================================================
// =============== FALLBACK ===============================
// ========================================================
Route::fallback(fn() => redirect()->route('landing-page'));
