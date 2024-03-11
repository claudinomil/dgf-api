<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/index', [DashboardController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/dashboard1', [DashboardController::class, 'dashboard1'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard2', [DashboardController::class, 'dashboard2'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard3', [DashboardController::class, 'dashboard3'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard4', [DashboardController::class, 'dashboard4'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard5', [DashboardController::class, 'dashboard5'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard6/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard6'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard7/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard7'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard8/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard8'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard9/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard9'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard10/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard10'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard11/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard11'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/dashboards_views', [DashboardController::class, 'dashboards_views'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/dashboards_views_salvar', [DashboardController::class, 'dashboards_views_salvar'])->middleware(['auth:api', 'scope:claudino']);
});
