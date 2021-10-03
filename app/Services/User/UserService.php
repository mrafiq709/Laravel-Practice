<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Models\User\AuthPassportUser;
use App\Repositories\User\UserRepository;
use App\Services\BaseServices;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

/**
 * Class UserService
 *
 * @property-read UserRepository $repository
 *
 * @package App\Services\User
 */
class UserService extends BaseServices
{
    /**
     * @return string
     */
    public function repository(): string
    {
        return UserRepository::class;
    }

    /**
     * @param AuthPassportUser $passportUser
     *
     * @return User
     */
    public function createUserFromAuthPassport(AuthPassportUser $passportUser): User
    {
        $user = new User();
        $user->id = $passportUser->id;
        $user->name = $passportUser->name;
        $user->email = $passportUser->email;
        $user->password = bcrypt(Str::random(30));

        try {
            $user->save();
        } catch (QueryException $e) {
            // 1062 is error code for duplicate entry
            if ($e->errorInfo[1] === 1062) {
                $user = User::where('email', $passportUser->email)->first();
            } else {
                // throwException($e); undefined in Laravel 7, work in Laravel 6
                responder()->error($e->getMessage());
            }
        }

        return $user;
    }
}
