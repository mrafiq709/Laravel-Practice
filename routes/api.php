<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
// Get all country
Route::get('country', 'Country\CountryController@country');

//GGet country by id
Route::get('country/{id}', 'Country\CountryController@countryById');

// Save country
Route::post('country', 'Country\CountryController@countrySave');

// Update country
Route::put('country/{id}', 'Country\CountryController@countryUpdate');

// Delete country
Route::delete('country/{id}', 'Country\CountryController@countryDelete');
*/

Route::apiResource('country', 'Country\CountryResource');