<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDataController;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// register
Route::post('user/register', [UserDataController::class, 'register']);
// create toko
Route::post('user/create-store/{userId}', [UserDataController::class, 'createStore']);
// // get all data register
Route::get('user/get-data', [UserDataController::class, 'data']);
// // user get all data with store
Route::get('user/profile-toko/{userId}', [UserDataController::class, 'getDataWithProfile']);


use App\Http\Controllers\API\AuthController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
