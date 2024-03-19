<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\SessionRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(SessionRating $sessionRating, Request $request): JsonResponse
    {
        $rating = $request->input('rating');
        $feedback = $request->input('feedback');
        Rating::forceCreate([
            'patient_id' => $sessionRating->patient_id,
            'doctor_id' => $sessionRating->doctor_id,
            'rating' => (int)$rating,
            'feedback' => $feedback
        ]);
        $sessionRating->delete();
        return response()->json(['message' => 'Successfully Rated']);
    }

    public function cancel(SessionRating $sessionRating): JsonResponse
    {
        $sessionRating->delete();
        return response()->json(['message' => 'Rating Cancel']);
    }
}
