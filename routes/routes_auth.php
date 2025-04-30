<?php

use App\Http\Controllers\PasswordResetsController;
use App\Http\Controllers\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    //Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    //Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    //Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    //Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

Route::post('password_resets/{token}/store', [PasswordResetsController::class, 'store']);
Route::post('password_resets_confirm/store', [PasswordResetsController::class, 'confirm']);
Route::post('password_resets_update_delete/store', [PasswordResetsController::class, 'update_delete']);
