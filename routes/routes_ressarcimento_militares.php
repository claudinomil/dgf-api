<?php

use App\Http\Controllers\RessarcimentoMilitarController;

Route::prefix('ressarcimento_militares')->group(function () {
    Route::get('/index', [RessarcimentoMilitarController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [RessarcimentoMilitarController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [RessarcimentoMilitarController::class, 'filter'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [RessarcimentoMilitarController::class, 'destroy'])->middleware(['auth:api']);

    Route::post('/importar', [RessarcimentoMilitarController::class, 'importar']);

    Route::get('/auxiliary/tables', [RessarcimentoMilitarController::class, 'auxiliary'])->middleware(['auth:api']);
});
