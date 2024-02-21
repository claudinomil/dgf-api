<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/index', [DashboardController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/acessos', [DashboardController::class, 'acessos'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/dashboard1', [DashboardController::class, 'dashboard1'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard2', [DashboardController::class, 'dashboard2'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard3', [DashboardController::class, 'dashboard3'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard4', [DashboardController::class, 'dashboard4'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/dashboard5', [DashboardController::class, 'dashboard5'])->middleware(['auth:api', 'scope:claudino']);
});
