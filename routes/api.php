<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v01')->group(function () {



    // to examine "throttle:login" see: RouteServiceProvider
    // Route::middleware('throttle:login')->group(function () {
        Route::post('/login', [\App\Http\Controllers\LoginController::class, 'preLogin']);
        Route::patch('/login', [\App\Http\Controllers\LoginController::class, 'loginWithToken']);
        // Route::post('/login-simple', \App\Http\Controllers\LoginSimpleController::class);
    // });

    // Route::get('/csrf', \App\Http\Controllers\CsrfController::class);

    Route::middleware('auth')->group(function () {

        Route::post('/logout', \App\Http\Controllers\LogoutController::class);

        Route::get('/me', \App\Http\Controllers\MeController::class);

        Route::post('/password', \App\Http\Controllers\NewPasswordController::class);

        Route::get('/sessions', \App\Http\Controllers\SessionsController::class);
        Route::delete('/session/{session}', \App\Http\Controllers\SessionDestroyController::class);

        // Route::get('/password-reset', \App\Http\Controllers\PasswordResetRequestController::class);
        // Route::post('/password-reset', \App\Http\Controllers\PasswordResetController::class);

        // Route::get('/users', [\App\Http\Controllers\UserController::class, 'update']);
        // Route::put('/user/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        // Route::delete('/user/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

    });

});
