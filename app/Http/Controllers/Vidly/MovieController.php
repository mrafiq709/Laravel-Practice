<?php

namespace App\Http\Controllers\Vidly;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vidly\Movie\CreateMovieRequest;
use App\Http\Requests\Vidly\Movie\IndexMovieRequest;
use App\Services\Vidly\Movie\CreateMovieService;
use App\Services\Vidly\Movie\IndexMovieService;

class MovieController extends Controller
{
    /**
     * Create Genre.
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
     * Index Genre.
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
}
