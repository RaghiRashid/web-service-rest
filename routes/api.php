<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\UserController;
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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('user', 'App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::apiResource('users', UserController::class);
    Route::apiResource('address', AddressController::class);
});
