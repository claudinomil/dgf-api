<?php

use App\Http\Controllers\FerramentaController;

Route::prefix('ferramentas')->group(function () {
    Route::get('/index', [FerramentaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FerramentaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [FerramentaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [FerramentaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [FerramentaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [FerramentaController::class, 'destroy'])->middleware(['auth:api']);
});
