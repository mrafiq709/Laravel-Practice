<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Services\BaseServices;

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
}
