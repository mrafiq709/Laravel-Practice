<?php

use App\Http\Controllers\Auth\CustomAccessTokenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class . '@login');
Route::post('/register', RegisterController::class . '@register');
Route::post('/oauth/token', [
    'uses' => CustomAccessTokenController::class . '@issueUserToken',
    'middleware' => 'throttle:5,1'
]);