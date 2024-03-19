<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\ZoomAuthController;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\PutAuthProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserProfile extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin|doctor']);
    }

    public function index(): Response
    {
        return Inertia::render('Shared/Profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        (new PutAuthProfileService())->profileUpdate($request);
        return to_route('dashboard.auth.show');
    }

    public function attachZoom(Doctor $doctor): RedirectResponse
    {
        return (new ZoomAuthController($doctor))->redirectToZoom();
    }
}




