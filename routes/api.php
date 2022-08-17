<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
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

Route::fallback(function (){
    abort(404, 'API resource not found');
});

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->group( function () {
        Route::get('logout', 'logout');
    });
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('users', UsersController::class);
});