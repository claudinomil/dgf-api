<?php

use App\Http\Controllers\AlimentacaoUnidadeController;

Route::prefix('alimentacao_unidades')->group(function () {
    Route::get('/index', [AlimentacaoUnidadeController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [AlimentacaoUnidadeController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [AlimentacaoUnidadeController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [AlimentacaoUnidadeController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [AlimentacaoUnidadeController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [AlimentacaoUnidadeController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [AlimentacaoUnidadeController::class, 'auxiliary'])->middleware(['auth:api']);
});
