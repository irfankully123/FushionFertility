<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the authenticated user is an admin
        if ($request->user() && $request->user()->hasRole('super')) {
            return $next($request);
        }
        // If the user is not an admin, you can redirect them to a specific route or display an error message
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}