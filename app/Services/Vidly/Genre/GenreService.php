<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Genre;

use App\Repositories\Vidly\GenreRepository;
use App\Services\BaseServices;

/**
 * Class GenreService
 *
 * @property-read GenreRepository $repository
 *
 * @package App\Services\Vidly\Genre
 */
class GenreService extends BaseServices
{
    /**
     * @return string
     */
    public function repository(): string
    {
        return GenreRepository::class;
    }
}
