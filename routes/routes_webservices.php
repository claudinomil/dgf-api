<?php

use App\Http\Controllers\WebserviceController;

Route::prefix('webservices')->group(function () {
    Route::get('/militar/{field}/{value}', [WebserviceController::class, 'militar'])->middleware(['auth:api']);
});
