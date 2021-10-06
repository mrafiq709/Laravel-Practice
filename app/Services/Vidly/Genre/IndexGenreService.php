<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Genre;

use App\Http\Requests\Vidly\Genre\IndexGenreRequest;
use App\Services\TraitRepositoryService;

/**
 * Class IndexGenreService
 * 
 * @package App\Services\Vidly\Genre
 */
class IndexGenreService extends GenreService 
{
    use TraitRepositoryService;
    /**
     * Index Genre
     * 
     * @param IndexGenreRequest $request
     */
    public function index(IndexGenreRequest $request)
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