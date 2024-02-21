<?php

use App\Http\Controllers\RessarcimentoDashboardController;

Route::prefix('ressarcimento_dashboards')->group(function () {
    Route::get('/index', [RessarcimentoDashboardController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/acessos', [RessarcimentoDashboardController::class, 'acessos'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/dashboard6/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard6'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard7/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard7'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard8/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard8'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard9/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard9'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard10/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard10'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard11/{periodo1}/{periodo2}/{orgao_id}', [RessarcimentoDashboardController::class, 'dashboard11'])->middleware(['auth:api', 'scope:claudino']);
});
