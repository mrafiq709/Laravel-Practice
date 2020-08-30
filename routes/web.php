<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('push-notifications')->get('/push-notifications', 'PushNotifications\PushNotificationController@index');
Route::name('push-notification.create')->get('/push-notifications/create','PushNotifications\PushNotificationController@create');
Route::name('push-notification.store')->post('/push-notification/store', 'PushNotifications\PushNotificationController@store');