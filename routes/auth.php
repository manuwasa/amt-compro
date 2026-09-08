<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

// Neither public self-registration nor self-service password reset is exposed, because
// every account here is an admin account:
//
//  - /register would let anyone grant themselves admin-panel access, since the
//    `users.role` column defaults to 'admin'.
//  - /forgot-password answered differently for a registered and an unregistered
//    address, which made it an oracle for enumerating valid admin emails, and it was
//    the only unauthenticated endpoint with no rate limit of its own.
//
// Accounts are created only via `php artisan admin:create` or the admin Users screen,
// both of which set the role explicitly. A superadmin resets another user's password
// from Admin -> Users -> Edit.
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
