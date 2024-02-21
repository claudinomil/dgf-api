<?php

use App\Http\Controllers\RessarcimentoRelatorioController;

Route::prefix('ressarcimento_relatorios')->group(function () {
    Route::get('/index', [RessarcimentoRelatorioController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/acessos', [RessarcimentoRelatorioController::class, 'acessos'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/executar_relatorio_6/{referencia}/{orgao_id}', [RessarcimentoRelatorioController::class, 'executar_relatorio_6'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_7/{referencia}/{orgao_id}', [RessarcimentoRelatorioController::class, 'executar_relatorio_7'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/executar_relatorio_8/{referencia}/{orgao_id}/{saldo}', [RessarcimentoRelatorioController::class, 'executar_relatorio_8'])->middleware(['auth:api', 'scope:claudino']);
});
