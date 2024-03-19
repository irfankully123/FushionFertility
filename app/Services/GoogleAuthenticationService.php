<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Socialite\Contracts\User as SocialiteUser;


class GoogleAuthenticationService
{

    private string $user_type = 'patient';

    private function googleUser(SocialiteUser $user): ?User
    {
        return User::where('email', $user->getEmail())
            ->where('google_id', $user->getId())
            ->first();
    }

    private function notGoogleUser(SocialiteUser $user): ?User
    {
        return User::where('email', $user->getEmail())
            ->whereNull('google_id')
            ->first();
    }

    #[ArrayShape(['name' => "null|string", 'email' => "null|string", 'google_id' => "string", 'user_type' => "string", 'email_verified_at' => "\Illuminate\Support\Carbon", 'password' => "string"])]
    private function newGoogleUser(SocialiteUser $user): array
    {
        return [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'google_id' => $user->getId(),
            'user_type' => $this->user_type,
            'email_verified_at' => now(),
            'password' => Hash::make($user->getId())
        ];
    }

    private function updateExistingUser(SocialiteUser $user): ?User
    {
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            $existingUser->google_id = $user->getId();
            $existingUser->email_verified_at = now();
            $existingUser->save();
        }

        return $existingUser;
    }

    private function safeRegister(SocialiteUser $user): ?User
    {
        $existingUser = User::where('email', $user->getEmail())->first();

        if (!$existingUser) {
            $newUser = new User($this->newGoogleUser($user));
            $newUser->save();
            $newUser->assignRole('patient');
            $existingUser = $newUser;
        }

        return $existingUser;
    }

    public function googleLoginSystem(SocialiteUser $user): void
    {
        $googleUser = $this->googleUser($user);
        if ($googleUser) {
            Auth::login($googleUser);
        } else {
            $notGoogleUser = $this->notGoogleUser($user);
            if ($notGoogleUser) {
                Auth::login($this->updateExistingUser($user));
            } else {
                Auth::login($this->safeRegister($user));
            }
        }
    }


}
