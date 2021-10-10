<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Vidly\Movie;

use App\Http\Requests\Vidly\Movie\UpdateMovieRequest;
use App\Models\Vidly\Genre;
use App\Models\Vidly\Movie;

/**
 * Class UpdateMovieService
 * 
 * @package App\Services\Vidly\Movie
 */
class UpdateMovieService extends MovieService 
{

    /**
     * Update Movie
     * 
     * @param UpdateMovieRequest $request
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
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