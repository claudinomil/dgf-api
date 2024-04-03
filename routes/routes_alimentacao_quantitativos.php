<?php

use App\Http\Controllers\AlimentacaoQuantitativoController;

Route::prefix('alimentacao_quantitativos')->group(function () {
    Route::get('/index', [AlimentacaoQuantitativoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [AlimentacaoQuantitativoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [AlimentacaoQuantitativoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [AlimentacaoQuantitativoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [AlimentacaoQuantitativoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [AlimentacaoQuantitativoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [AlimentacaoQuantitativoController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
