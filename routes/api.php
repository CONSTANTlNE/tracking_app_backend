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

Route::middleware('auth:sanctum')->post('/api/update-fcm-token', function (Request $request) {
    $request->validate(['token' => 'required|string']);
    $request->user()->update(['fcm_token' => $request->token]);
    return response()->json(['status' => 'ok']);
});
