<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Movie;

use App\Http\Requests\Vidly\Movie\CreateMovieRequest;
use App\Models\Vidly\Genre;

/**
 * Class CreateMovieService
 * 
 * @package App\Services\Vidly\Movie
 */
class CreateMovieService extends MovieService 
{

    /**
     * Create Movie
     * 
     * @param CreateMovieRequest $request
     */
    public function store(CreateMovieRequest $request)
    {
        $movie = $this->repository->firstOrNew([
            'title' => $request->title
        ]);
        
        $movie->creator = isset($request->user()->id) ? $request->user()->id : 5;
        $movie->title = $request->title;
        $movie->stock = $request->stock;
        $movie->rate = $request->rate;
        $movie->liked = isset($request->liked) ? $request->liked : false;
        $movie->genre = Genre::find($request->genre_id)->toArray();
        $movie->save();

        responder()->success($movie->toArray());
    }
}

?>