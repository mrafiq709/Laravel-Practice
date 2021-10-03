<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\User;

/**
 * Class UserRepository
 *
 * @method User newModel()
 *
 * @package App\Repositories\Users
 */
class UserRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
