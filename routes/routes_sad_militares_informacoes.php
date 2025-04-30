<?php

use App\Http\Controllers\SadMilitaresInformacoesController;

Route::prefix('sad_militares_informacoes')->group(function () {
    Route::get('/index', [SadMilitaresInformacoesController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [SadMilitaresInformacoesController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [SadMilitaresInformacoesController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [SadMilitaresInformacoesController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [SadMilitaresInformacoesController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [SadMilitaresInformacoesController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [SadMilitaresInformacoesController::class, 'auxiliary'])->middleware(['auth:api']);
    Route::get('/profiledata/{id}', [SadMilitaresInformacoesController::class, 'profileData'])->middleware(['auth:api']);
    Route::put('/update/foto/{id}', [SadMilitaresInformacoesController::class, 'updateFoto'])->middleware(['auth:api']);
});
