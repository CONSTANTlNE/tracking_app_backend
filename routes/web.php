<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.dashboard'));

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
    Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');

    Route::post('users/{user}/tokens', [TokenController::class, 'store'])->name('users.tokens.store');
    Route::delete('users/{user}/tokens/{tokenId}', [TokenController::class, 'destroy'])->name('users.tokens.destroy');
});
