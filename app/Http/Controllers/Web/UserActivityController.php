<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class UserActivityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $users = User::whereNotNull('last_seen')
                ->orderBy('last_seen', 'DESC')
                ->get();

            if (!$users) {
                return response()->json([
                    'message' => 'users not found'
                ], ResponseAlias::HTTP_NOT_FOUND);
            }

            return response()->json($users, ResponseAlias::HTTP_OK);

        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
