<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // ✅ BIARKAN POST REGISTER (UNTUK MODAL)
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');

    // ❌ COMMENT GET REGISTER (BIAR GA MUNCUL PAGE LARAVEL)
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');

    // ✅ BIARKAN POST LOGIN (UNTUK MODAL)  
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    // ❌ COMMENT GET LOGIN (BIAR GA MUNCUL PAGE LARAVEL)
    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //     ->name('login');

    // ✅ FITUR FORGOT PASSWORD (BISA DIBIARKAN ATAU DI-COMMENT)
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // ✅ FITUR VERIFIKASI EMAIL (BISA DIBIARKAN)
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // ✅ FITUR KONFIRMASI PASSWORD (BISA DIBIARKAN)
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // ✅ UPDATE PASSWORD (BISA DIBIARKAN)
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ✅ LOGOUT (SUDAH ADA DI WEB.PHP, TAPI BIARKAN UNTUK BACKUP)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});