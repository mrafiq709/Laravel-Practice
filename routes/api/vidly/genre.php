<?php

use App\Http\Controllers\Vidly\GenreController;
use Illuminate\Support\Facades\Route;

Route::post('/genres', GenreController::class . '@store');
Route::get('/genres', GenreController::class . '@index');
Route::get('/genres/{genre}', GenreController::class . '@show');