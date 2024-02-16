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

// register
Route::post('user/register', 'UserDataController@register');
// create toko
Route::post('user/create-store/{userId}', 'UserDataController@createStore');
// get all data register
Route::get('user/get-data', 'UserDataController@data');
// user get all data with store
Route::get('user/profile-toko/{userId}', 'UserDataController@getDataWithProfile');
