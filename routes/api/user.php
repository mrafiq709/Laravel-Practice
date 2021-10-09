<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', UserController::class . '@index');
Route::get('/users/{user}', UserController::class . '@show');
Route::put('/users/{user}', UserController::class . '@update');
Route::delete('/users/{user}', UserController::class . '@destroy');
Route::get('/me', UserController::class . '@me');
Route::get('/logout', AuthController::class . '@logout');