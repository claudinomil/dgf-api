<?php

use App\Http\Controllers\RessarcimentoRecebimentoController;

Route::prefix('ressarcimento_recebimentos')->group(function () {
    Route::get('/index', [RessarcimentoRecebimentoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [RessarcimentoRecebimentoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [RessarcimentoRecebimentoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('', [RessarcimentoRecebimentoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dados_modal/{referencia}', [RessarcimentoRecebimentoController::class, 'dados_modal'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/registros_alterar/{referencia}/{orgao_id}', [RessarcimentoRecebimentoController::class, 'registros_alterar'])->middleware(['auth:api', 'scope:claudino']);
});
