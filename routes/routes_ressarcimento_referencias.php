<?php

use App\Http\Controllers\RessarcimentoReferenciaController;

Route::prefix('ressarcimento_referencias')->group(function () {
    Route::get('/index', [RessarcimentoReferenciaController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [RessarcimentoReferenciaController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [RessarcimentoReferenciaController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [RessarcimentoReferenciaController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [RessarcimentoReferenciaController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [RessarcimentoReferenciaController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [RessarcimentoReferenciaController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);
});
