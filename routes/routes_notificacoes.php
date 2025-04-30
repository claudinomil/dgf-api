<?php

use App\Http\Controllers\NotificacaoController;

Route::prefix('notificacoes')->group(function () {
    Route::get('/index', [NotificacaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [NotificacaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [NotificacaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [NotificacaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [NotificacaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [NotificacaoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/unreadNotificacoes/{id}', [NotificacaoController::class, 'unreadNotificacoes'])->middleware(['auth:api']);
});
