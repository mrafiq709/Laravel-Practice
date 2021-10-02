<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/users', UserController::class . '@index');
Route::middleware('auth:api')->get('/users/{user}', UserController::class . '@show');
Route::middleware('auth:api')->put('/users/{user}', UserController::class . '@update');
Route::middleware('auth:api')->delete('/users/{user}', UserController::class . '@destroy');