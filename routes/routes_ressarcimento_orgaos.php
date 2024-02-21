<?php

use App\Http\Controllers\RessarcimentoOrgaoController;

Route::prefix('ressarcimento_orgaos')->group(function () {
    Route::get('/index', [RessarcimentoOrgaoController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [RessarcimentoOrgaoController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [RessarcimentoOrgaoController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [RessarcimentoOrgaoController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [RessarcimentoOrgaoController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [RessarcimentoOrgaoController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [RessarcimentoOrgaoController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/quantidade_registros', [RessarcimentoOrgaoController::class, 'quantidade_registros'])->middleware(['auth:api', 'scope:claudino']);
});
