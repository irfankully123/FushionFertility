<?php

namespace App\Http\Middleware;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'inertia-root';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function clientTimeZone(): string
    {
        $cacheKey = 'client_timezone';
        $cacheDuration = 60; // Cache duration in minutes

        // Check if the client timezone is already cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $apiKey = '7a6081fa2b8e4de992f735ae3279ca43'; // Replace with your actual API key
        $apiUrl = "https://api.ipgeolocation.io/ipgeo?apiKey={$apiKey}";

        try {
            $response = Http::get($apiUrl);

            if (!$response->ok()) {
                throw new Exception('Failed to fetch client timezone');
            }

            $data = $response->json();

            $timezone = $data['time_zone']['name'];

            // Cache the client timezone for future use
            Cache::put($cacheKey, $timezone, $cacheDuration);

            return $timezone;
        } catch (Exception $e) {
            report($e);
            // Return a default timezone if the API call fails
            return config('app.timezone', 'UTC');
        }
    }


    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        $clientTimezone = session('timeZone');
        return array_merge(parent::share($request), [
            'logo'=>asset('web/assets/img/logo.png'),
            'auth' => Auth::user(),
            'super_admin' => Auth::user() && Auth::user()->hasRole('super'),
            'doctor' => Auth::user() && Auth::user()->hasRole('doctor'),
            'admin' => Auth::user() && Auth::user()->hasRole('admin'),
            'authPermissions' => Auth::user() ? Auth::user()->permissions()->pluck('name')->toArray() : [],
            'doctorObject' => Auth::check() ? Auth::user()->doctor()->first() ?? [] : [],
            'timezone' => config('app.timezone','UTC'),
            'clientTimeZone' => $clientTimezone==null ? config('app.timezone','UTC') : $clientTimezone
        ]);
    }
}
