<?php

use App\Http\Controllers\TransacaoController;

Route::prefix('transacoes')->group(function () {
    Route::get('/index', [TransacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [TransacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [TransacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [TransacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [TransacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [TransacaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [TransacaoController::class, 'auxiliary'])->middleware(['auth:api']);
});
