<?php

use App\Http\Controllers\RelatorioController;

Route::prefix('relatorios')->group(function () {
    Route::get('/index', [RelatorioController::class, 'index'])->middleware(['auth:api']);

    Route::get('/relatorios', [RelatorioController::class, 'relatorios'])->middleware(['auth:api']);

    Route::get('/relatorio1/{grupo_id}', [RelatorioController::class, 'relatorio1'])->middleware(['auth:api']);
    Route::get('/relatorio2/{grupo_id}/{situacao_id}', [RelatorioController::class, 'relatorio2'])->middleware(['auth:api']);
    Route::get('/relatorio3/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}', [RelatorioController::class, 'relatorio3'])->middleware(['auth:api']);
    Route::get('/relatorio4/{date}/{title}/{notificacao}/{user_id}', [RelatorioController::class, 'relatorio4'])->middleware(['auth:api']);
    Route::get('/relatorio5/{name}/{descricao}/{url}/{user_id}', [RelatorioController::class, 'relatorio5'])->middleware(['auth:api']);
    Route::get('/relatorio6/{referencia}/{orgao_id}', [RelatorioController::class, 'relatorio6'])->middleware(['auth:api']);
    Route::get('/relatorio7/{referencia}/{orgao_id}', [RelatorioController::class, 'relatorio7'])->middleware(['auth:api']);
    Route::get('/relatorio8/{referencia}/{orgao_id}/{saldo}', [RelatorioController::class, 'relatorio8'])->middleware(['auth:api']);
});
