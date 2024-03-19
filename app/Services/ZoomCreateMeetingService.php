<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ZoomCreateMeetingService
{
    /**
     * @throws Exception
     */
    public function getAccessToken(string $accountID, string $username, string $password): string
    {
        try {
            $response = Http::withHeaders(['Authorization' => 'Basic ' . base64_encode($username . ':' . $password)])
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'account_credentials',
                    'account_id' => $accountID,
                ]);

            if ($response->successful()) {
                $response = json_decode($response);
                return $response->access_token;
            } else {
                $error = $response->json();
                return response()->json($error, $response->status());
            }

        } catch (Exception $exception) {
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }

        return response()->json(['error' => 'An error occurred'], 500);
    }


    /**
     * @throws Exception
     */
    public function createMeeting(string $dateTime, int $consultantTime, string $accountID, string $username, string $password): JsonResponse
    {
        $accessToken = $this->getAccessToken($accountID, $username, $password);

        $url = "https://api.zoom.us/v2/users/me/meetings";
        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ];
            $body = [
                'topic' => 'Appointment Meeting',
                'type' => 2,
                'start_time' => $dateTime,
                'duration' => $consultantTime,
                'timezone' => env('zoom_timezone'),
                'settings' => [
                    'join_before_host' => false,
                    'waiting_room' => false,
                ],
            ];

            $response = Http::withHeaders($headers)->post($url, $body);

            if ($response->successful()) {
                $meeting = $response->json();
                $startUrl = $meeting['start_url'];
                $joinUrl = $meeting['join_url'];

                return response()->json([
                    'start_url' => $startUrl,
                    'join_url' => $joinUrl
                ]);
            } else {
                $error = $response->json();
                return response()->json($error, $response->status());
            }
        } catch (Exception $exception) {
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
        return response()->json(['error' => 'An error occurred'], 500);
    }
}
