<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function log(Request $request): JsonResponse
    {
        $data = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $user = $request->user();

        Log::channel('locations')->info('Location received', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        return response()->json(['status' => 'ok']);
    }
}
