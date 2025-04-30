<?php

use App\Http\Controllers\OperacaoController;

Route::prefix('operacoes')->group(function () {
    Route::get('/index', [OperacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [OperacaoController::class, 'show'])->middleware(['auth:api']);
    Route::post('/store', [OperacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [OperacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [OperacaoController::class, 'destroy'])->middleware(['auth:api']);
});
