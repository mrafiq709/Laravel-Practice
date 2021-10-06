<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Movie;

use App\Repositories\Vidly\MovieRepository;
use App\Services\BaseServices;

/**
 * Class MovieService
 *
 * @property-read MovieRepository $repository
 *
 * @package App\Services\Vidly\Movie
 */
class MovieService extends BaseServices
{
    /**
     * @return string
     */
    public function repository(): string
    {
        return MovieRepository::class;
    }
}
