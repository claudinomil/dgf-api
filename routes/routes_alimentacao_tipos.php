<?php

use App\Http\Controllers\AlimentacaoTipoController;

Route::prefix('alimentacao_tipos')->group(function () {
    Route::get('/index', [AlimentacaoTipoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [AlimentacaoTipoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [AlimentacaoTipoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [AlimentacaoTipoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [AlimentacaoTipoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [AlimentacaoTipoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [AlimentacaoTipoController::class, 'auxiliary'])->middleware(['auth:api']);
});
