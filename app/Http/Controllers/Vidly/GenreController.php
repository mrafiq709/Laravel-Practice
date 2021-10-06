<?php

namespace App\Http\Controllers\Vidly;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vidly\Genre\CreateGenreRequest;
use App\Http\Requests\Vidly\Genre\IndexGenreRequest;
use App\Services\Vidly\Genre\CreateGenreService;
use App\Services\Vidly\Genre\IndexGenreService;

class GenreController extends Controller
{
    /**
     * Create Genre.
     * 
     * @param CreateGenreRequest $request
     * @param CreateGenreService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGenreRequest $request, CreateGenreService $service)
    {
        $service->store($request);
        return responder()->toJson();
    }

    /**
     * Index Genre.
     * 
     * @param IndexGenreRequest $request
     * @param IndexGenreService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexGenreRequest $request, IndexGenreService $service)
    {
        $service->index($request);
        return responder()->toJson();
    }
}
