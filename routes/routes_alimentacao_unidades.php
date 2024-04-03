<?php

use App\Http\Controllers\AlimentacaoUnidadeController;

Route::prefix('alimentacao_unidade')->group(function () {
    Route::get('/index', [AlimentacaoUnidadeController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [AlimentacaoUnidadeController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [AlimentacaoUnidadeController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [AlimentacaoUnidadeController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [AlimentacaoUnidadeController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [AlimentacaoUnidadeController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [AlimentacaoUnidadeController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
