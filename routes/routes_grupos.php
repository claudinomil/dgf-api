<?php

use App\Http\Controllers\GrupoController;

Route::prefix('grupos')->group(function () {
    Route::get('/index', [GrupoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [GrupoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [GrupoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [GrupoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [GrupoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [GrupoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [GrupoController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
