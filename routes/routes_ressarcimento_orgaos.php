<?php

use App\Http\Controllers\RessarcimentoOrgaoController;

Route::prefix('ressarcimento_orgaos')->group(function () {
    Route::get('/index', [RessarcimentoOrgaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [RessarcimentoOrgaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [RessarcimentoOrgaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [RessarcimentoOrgaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [RessarcimentoOrgaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [RessarcimentoOrgaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [RessarcimentoOrgaoController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/quantidade_registros', [RessarcimentoOrgaoController::class, 'quantidade_registros'])->middleware(['auth:api']);
});
