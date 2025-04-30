<?php

use App\Http\Controllers\RessarcimentoConfiguracaoController;

Route::prefix('ressarcimento_configuracoes')->group(function () {
    Route::get('/index', [RessarcimentoConfiguracaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [RessarcimentoConfiguracaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [RessarcimentoConfiguracaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [RessarcimentoConfiguracaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [RessarcimentoConfiguracaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [RessarcimentoConfiguracaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [RessarcimentoConfiguracaoController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/quantidade_registros', [RessarcimentoConfiguracaoController::class, 'quantidade_registros'])->middleware(['auth:api']);
});
