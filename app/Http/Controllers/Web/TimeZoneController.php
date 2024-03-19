<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TimeZoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->has('timezone')) {
            $timezone = $request->input('timezone');
            session()->put('timeZone', $timezone);
            return response()->json(['message' => 'Timezone set successfully']);
        } else {
            return response()->json(['message' => 'Timezone not provided'], 400);
        }
    }
}
