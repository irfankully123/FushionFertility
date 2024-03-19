<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ZoomAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class ZoomAuthController extends Controller
{
    private Doctor $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor=$doctor;
    }

    public function redirectToZoom(): RedirectResponse
    {
        Session::put('doctor', $this->doctor);
        return Socialite::driver('zoom')->redirect();
    }

    public function handleCallback(): RedirectResponse
    {   $doctor = Session::get('doctor');
        $user = Socialite::driver('zoom')->user();
        $doctor->forceFill(['is_zoom_attach'=>'1'])->save();
        ZoomAccess::create([
            'doctor_id'=>$doctor->id,
            'zoom_id'=>$user->getId(),
            'refresh_token'=>$user->refreshToken
        ]);
        Session::forget('doctor');
        return redirect('/dashboard/home');
    }

}



