<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/ping', function (Request $request) {
    return 'pong';
});

Route::group(['prefix' => 'smartthings'], function () {
    Route::post('devices', 'DeviceController@post')->name('devices.post');
    Route::get('devices', 'DeviceController@get')->name('devices.get');

    Route::post('event', 'EventController@post')->name('event.post');
    Route::get('event', 'EventController@post')->name('event.get');

	Route::post('register', 'RegisterController@post')->name('register.post');
    Route::get('register', 'RegisterController@post')->name('register.get');
});