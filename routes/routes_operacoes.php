<?php

use App\Http\Controllers\OperacaoController;

Route::prefix('operacoes')->group(function () {
    Route::get('/index', [OperacaoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [OperacaoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [OperacaoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [OperacaoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [OperacaoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);
});
