<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\GoogleAuthenticationService;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthentication extends Controller
{


    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(): RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        (new GoogleAuthenticationService())->googleLoginSystem($user);
        return redirect()->route('home');
    }


}
