<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Http\Requests\User\UpdateUserRequest;
use App\User;

/**
 * Class UpdateUserService
 * 
 * @package App\Services\User
 */
class UpdateUserService extends UserService 
{

    /**
     * Update User
     * 
     * @param UpdateUserRequest $request
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->save();

        return response()->json($user->toArray());
    }
}

?>