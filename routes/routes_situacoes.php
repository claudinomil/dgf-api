<?php

use App\Http\Controllers\SituacaoController;

Route::prefix('situacoes')->group(function () {
    Route::get('/index', [SituacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [SituacaoController::class, 'show'])->middleware(['auth:api']);
    Route::post('/store', [SituacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [SituacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [SituacaoController::class, 'destroy'])->middleware(['auth:api']);
});
