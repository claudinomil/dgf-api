<?php

use App\Http\Controllers\AlimentacaoRemanejamentoController;

Route::prefix('alimentacao_remanejamentos')->group(function () {
    Route::get('/index', [AlimentacaoRemanejamentoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [AlimentacaoRemanejamentoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [AlimentacaoRemanejamentoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [AlimentacaoRemanejamentoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [AlimentacaoRemanejamentoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [AlimentacaoRemanejamentoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [AlimentacaoRemanejamentoController::class, 'auxiliary'])->middleware(['auth:api']);
});
