<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/test-location', function (Request $request) {
    Log::info('Location ping', $request->only(['lat', 'lng']));
    return response()->json(['status' => 'ok']);
});
