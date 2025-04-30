<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/index', [DashboardController::class, 'index'])->middleware(['auth:api']);

    Route::get('/dashboard1', [DashboardController::class, 'dashboard1'])->middleware(['auth:api']);
    Route::get('/dashboard2', [DashboardController::class, 'dashboard2'])->middleware(['auth:api']);
    Route::get('/dashboard3', [DashboardController::class, 'dashboard3'])->middleware(['auth:api']);
    Route::get('/dashboard4', [DashboardController::class, 'dashboard4'])->middleware(['auth:api']);
    Route::get('/dashboard5', [DashboardController::class, 'dashboard5'])->middleware(['auth:api']);

    Route::get('/dashboard6/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard6'])->middleware(['auth:api']);
    Route::get('/dashboard7/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard7'])->middleware(['auth:api']);
    Route::get('/dashboard8/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard8'])->middleware(['auth:api']);
    Route::get('/dashboard9/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard9'])->middleware(['auth:api']);
    Route::get('/dashboard10/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard10'])->middleware(['auth:api']);
    Route::get('/dashboard11/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'dashboard11'])->middleware(['auth:api']);

    Route::get('/dashboard12/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard12'])->middleware(['auth:api']);
    Route::get('/dashboard13/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard13'])->middleware(['auth:api']);
    Route::get('/dashboard14/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard14'])->middleware(['auth:api']);
    Route::get('/dashboard15/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard15'])->middleware(['auth:api']);
    Route::get('/dashboard16/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard16'])->middleware(['auth:api']);
    Route::get('/dashboard17/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'dashboard17'])->middleware(['auth:api']);

    Route::get('/dashboards_ids/{agrupamento_id}', [DashboardController::class, 'dashboards_ids'])->middleware(['auth:api']);
    Route::get('/dashboards_views', [DashboardController::class, 'dashboards_views'])->middleware(['auth:api']);
    Route::post('/dashboards_views_salvar', [DashboardController::class, 'dashboards_views_salvar'])->middleware(['auth:api']);
});
