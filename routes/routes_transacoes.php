<?php

use App\Http\Controllers\TransacaoController;

Route::prefix('transacoes')->group(function () {
    Route::get('/index', [TransacaoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [TransacaoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [TransacaoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [TransacaoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [TransacaoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [TransacaoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [TransacaoController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
