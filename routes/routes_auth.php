<?php
//password_resets
use App\Http\Controllers\PasswordResetsController;

Route::post('password_resets/{token}/store', [PasswordResetsController::class, 'store']);
Route::post('password_resets_confirm/store', [PasswordResetsController::class, 'confirm']);
Route::post('password_resets_update_delete/store', [PasswordResetsController::class, 'update_delete']);
