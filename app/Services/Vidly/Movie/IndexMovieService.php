<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Movie;

use App\Http\Requests\Vidly\Movie\IndexMovieRequest;
use App\Services\TraitRepositoryService;

/**
 * Class IndexMovieService
 * 
 * @package App\Services\Vidly\Genre
 */
class IndexMovieService extends MovieService 
{
    use TraitRepositoryService;
    /**
     * Index Genre
     * 
     * @param IndexMovieRequest $request
     */
    public function index(IndexMovieRequest $request)
    {
        $this->repository->resetCriteria();
        $this->addIndexCriteria();

         /**
         * @var Collection $paginate
         */
        $paginate = $this->repository->paginate($request->perPage());
        
        responder()->success($paginate->toArray());
    }
}

?>