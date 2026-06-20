<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/test-location', [LocationController::class, 'log']);
});
