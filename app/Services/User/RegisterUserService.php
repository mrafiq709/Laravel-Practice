<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Http\Requests\User\RegisterUserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterUserService
 * 
 * @package App\Services\User
 */
class RegisterUserService extends UserService 
{

    /**
     * Register User
     * 
     * @param RegisterUserRequest $request
     */
    public function register(RegisterUserRequest $request)
    {
        $user = User::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        responder()->success($user->toArray());
    }
}

?>