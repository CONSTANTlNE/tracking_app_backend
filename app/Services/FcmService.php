<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public function send(string $token, string $title, string $body, array $data = []): bool
    {
        try {
            $client = new \Google\Client();
            $client->setAuthConfig(config('services.fcm.credentials_path'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

            $projectId = config('services.fcm.project_id');

            $response = Http::withToken($accessToken)->post(
                "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
                [
                    'message' => [
                        'token' => $token,
                        'notification' => ['title' => $title, 'body' => $body],
                        'data' => $data,
                    ],
                ]
            );

            if (!$response->successful()) {
                Log::error('FCM send failed', ['response' => $response->body()]);
            }

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('FCM send exception', ['message' => $e->getMessage()]);
            return false;
        }
    }
}
