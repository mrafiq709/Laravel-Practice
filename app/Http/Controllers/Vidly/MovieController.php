<?php

namespace App\Http\Controllers\Vidly;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\Vidly\Movie\CreateMovieRequest;
use App\Http\Requests\Vidly\Movie\IndexMovieRequest;
use App\Http\Requests\Vidly\Movie\UpdateMovieRequest;
use App\Models\Vidly\Movie;
use App\Services\Vidly\Movie\CreateMovieService;
use App\Services\Vidly\Movie\IndexMovieService;
use App\Services\Vidly\Movie\UpdateMovieService;

class MovieController extends Controller
{
    /**
     * Create Movie.
     * 
     * @param CreateMovieRequest $request
     * @param CreateMovieService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMovieRequest $request, CreateMovieService $service)
    {
        $service->store($request);
        return responder()->toJson();
    }

    /**
     * Index Movie.
     * 
     * @param IndexMovieRequest $request
     * @param IndexMovieService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexMovieRequest $request, IndexMovieService $service)
    {
        $service->index($request);
        return responder()->toJson();
    }

    /**
     * Show Movie.
     * 
     * @param ApiRequest    $request
     * @param Movie         $movie
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ApiRequest $request, string $movie)
    {
        $movie = Movie::find($movie);
        responder()->success($movie->toArray());
        return responder()->toJson();
    }

    /**
     * Update Movie.
     * 
     * @param UpdateMovieRequest    $request
     * @param Movie                 $movie
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie, UpdateMovieService $service)
    {
        $service->update($request, $movie);
        return responder()->toJson();
    }
}
