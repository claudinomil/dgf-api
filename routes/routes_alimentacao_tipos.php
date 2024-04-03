<?php

use App\Http\Controllers\AlimentacaoTipoController;

Route::prefix('alimentacao_tipos')->group(function () {
    Route::get('/index', [AlimentacaoTipoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [AlimentacaoTipoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [AlimentacaoTipoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [AlimentacaoTipoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [AlimentacaoTipoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [AlimentacaoTipoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [AlimentacaoTipoController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
