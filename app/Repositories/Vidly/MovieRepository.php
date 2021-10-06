<?php

namespace App\Repositories\Vidly;

use App\Models\Vidly\Movie;
use App\Repositories\BaseRepository;

/**
 * Class MovieRepository
 *
 * @method User newModel()
 *
 * @package App\Repositories\Vidly
 */
class MovieRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Movie::class;
    }
}
