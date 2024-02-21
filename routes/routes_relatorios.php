<?php

use App\Http\Controllers\RelatorioController;

Route::prefix('relatorios')->group(function () {
    Route::get('/index', [RelatorioController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/acessos', [RelatorioController::class, 'acessos'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/executar_relatorio_1/{grupo_id}', [RelatorioController::class, 'executar_relatorio_1'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_2/{grupo_id}/{situacao_id}', [RelatorioController::class, 'executar_relatorio_2'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_3/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}', [RelatorioController::class, 'executar_relatorio_3'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_4/{date}/{title}/{notificacao}/{user_id}', [RelatorioController::class, 'executar_relatorio_4'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_5/{name}/{descricao}/{url}/{user_id}', [RelatorioController::class, 'executar_relatorio_5'])->middleware(['auth:api', 'scope:claudino']);
});
