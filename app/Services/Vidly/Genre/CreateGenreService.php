<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Genre;

use App\Http\Requests\Vidly\Genre\CreateGenreRequest;

/**
 * Class CreateGenreService
 * 
 * @package App\Services\Vidly\Genre
 */
class CreateGenreService extends GenreService 
{

    /**
     * Create Genre
     * 
     * @param CreateGenreRequest $request
     */
    public function store(CreateGenreRequest $request)
    {
        $genre = $this->repository->firstOrNew([
            'name' => $request->name
        ]);
        
        $genre->creator = $request->user()->id;
        $genre->name = $request->name;
        $genre->save();

        responder()->success($genre->toArray());
    }
}

?>