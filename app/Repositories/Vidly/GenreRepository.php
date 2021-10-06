<?php

namespace App\Repositories\Vidly;

use App\Models\Vidly\Genre;
use App\Repositories\BaseRepository;

/**
 * Class GenreRepository
 *
 * @method User newModel()
 *
 * @package App\Repositories\Vidly
 */
class GenreRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Genre::class;
    }
}
