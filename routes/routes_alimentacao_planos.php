<?php

use App\Http\Controllers\AlimentacaoPlanoController;

Route::prefix('alimentacao_planos')->group(function () {
    Route::get('/index', [AlimentacaoPlanoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [AlimentacaoPlanoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [AlimentacaoPlanoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [AlimentacaoPlanoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [AlimentacaoPlanoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [AlimentacaoPlanoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [AlimentacaoPlanoController::class, 'auxiliary'])->middleware(['auth:api']);
});
