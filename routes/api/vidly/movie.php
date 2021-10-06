<?php

use App\Http\Controllers\Vidly\MovieController;
use Illuminate\Support\Facades\Route;

Route::post('/movies', MovieController::class . '@store');
Route::get('/movies', MovieController::class . '@index');