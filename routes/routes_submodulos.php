<?php

use App\Http\Controllers\SubmoduloController;

Route::prefix('submodulos')->group(function () {
    Route::get('/search/{fieldSearch}/{fieldValue}/{fieldReturn}', [SubmoduloController::class, 'search'])->middleware(['auth:api']);
});
