<?php

use App\Http\Controllers\RessarcimentoCobrancaController;

Route::prefix('ressarcimento_cobrancas')->group(function () {
    Route::get('/index/{prefix_permissao}', [RessarcimentoCobrancaController::class, 'index'])->middleware(['auth:api']);

    Route::get('/dados_ressarcimento/{referencia}', [RessarcimentoCobrancaController::class, 'dados_ressarcimento'])->middleware(['auth:api']);
    Route::get('/gerar_cobrancas/{referencia}', [RessarcimentoCobrancaController::class, 'gerar_cobrancas'])->middleware(['auth:api']);
    Route::get('/gerar_pdfs/{referencia}', [RessarcimentoCobrancaController::class, 'gerar_pdfs'])->middleware(['auth:api']);
});
