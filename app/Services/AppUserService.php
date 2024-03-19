<?php

namespace App\Services;


use App\Http\Requests\Dashboard\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AppUserService
{


    public static function storeAsUser(StoreUserRequest $request) :User
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'email_verified_at'=>now(),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'admin'
        ]);
    }





}
