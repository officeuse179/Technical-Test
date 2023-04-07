<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

// check if user login and have created token
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('userprofile/{id}', [UsersController::class, 'userprofile']);
});

// route for user login
Route::post('login', [AuthController::class, 'login']);
// route for user register
Route::post('register', [AuthController::class, 'register']);