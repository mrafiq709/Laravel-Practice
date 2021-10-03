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
        if(isset($request->name))
            $user->name = $request->name;
        if(isset($request->email))
            $user->email = $request->email;
            
        $user->save();

        responder()->success($user->toArray());
    }
}

?>