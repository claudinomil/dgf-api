<?php

use App\Http\Controllers\EfetivoMilitarController;

Route::prefix('efetivo_militares')->group(function () {
    Route::get('/index', [EfetivoMilitarController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [EfetivoMilitarController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [EfetivoMilitarController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
});
