<?php

use App\Http\Controllers\SituacaoController;

Route::prefix('situacoes')->group(function () {
    Route::get('/index', [SituacaoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [SituacaoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [SituacaoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [SituacaoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [SituacaoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);
});
