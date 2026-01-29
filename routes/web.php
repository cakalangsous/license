<?php

use App\Http\Controllers\Core\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BlogController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');


Route::middleware('guest')->group(function () {
    Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login');

    Route::get('forgot-password', [App\Http\Controllers\Core\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [App\Http\Controllers\Core\Auth\PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:password-reset')
        ->name('password.email');

    Route::get('reset-password/{token}', [App\Http\Controllers\Core\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [App\Http\Controllers\Core\Auth\NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('two-factor-challenge', [App\Http\Controllers\Core\Auth\TwoFactorChallengeController::class, 'create'])
        ->name('two-factor.login');
    Route::post('two-factor-challenge', [App\Http\Controllers\Core\Auth\TwoFactorChallengeController::class, 'store'])
        ->name('two-factor.login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});
