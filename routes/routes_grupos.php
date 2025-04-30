<?php

use App\Http\Controllers\GrupoController;

Route::prefix('grupos')->group(function () {
    Route::get('/index', [GrupoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [GrupoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [GrupoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [GrupoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [GrupoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [GrupoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [GrupoController::class, 'auxiliary'])->middleware(['auth:api']);
});
