<?php

use App\Http\Controllers\RessarcimentoPagamentoController;

Route::prefix('ressarcimento_pagamentos')->group(function () {
    Route::get('/index', [RessarcimentoPagamentoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [RessarcimentoPagamentoController::class, 'show'])->middleware(['auth:api']);
    Route::put('/update/{id}', [RessarcimentoPagamentoController::class, 'update'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [RessarcimentoPagamentoController::class, 'filter'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [RessarcimentoPagamentoController::class, 'destroy'])->middleware(['auth:api']);

    Route::post('/importar/dados', [RessarcimentoPagamentoController::class, 'importar']);
    Route::get('/referencia_militares_ids_func/{referencia}', [RessarcimentoPagamentoController::class, 'referencia_militares_ids_func']);

    Route::get('/auxiliary/tables', [RessarcimentoPagamentoController::class, 'auxiliary'])->middleware(['auth:api']);
});
