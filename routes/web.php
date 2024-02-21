<?php

use App\Http\Controllers\CriarSubmodulos;
use App\Http\Controllers\SubmoduloController;
use Illuminate\Support\Facades\Route;

//Rotas para Criar Submódulos (Controller / Views / Js)
Route::get('/criarsubmodulos/{password}', [CriarSubmodulos::class, 'index'])->name('criarsubmodulos.index');
Route::post('/criarsubmodulos', [CriarSubmodulos::class, 'store'])->name('criarsubmodulos.store');

//Rotas para ADMIN
Route::prefix('modulos/submodulos')->group(function () {
    Route::get('', [SubmoduloController::class, 'admin_modulos_submodulos_all']);
    Route::get('/{ids}', [SubmoduloController::class, 'admin_modulos_submodulos_in']);
});





//Rotas de Testes
require __DIR__ . '/zzz_rotas_testes.php';
