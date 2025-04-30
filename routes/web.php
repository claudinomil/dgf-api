<?php

use App\Http\Controllers\SubmoduloController;
use Illuminate\Support\Facades\Route;

//Rotas para ADMIN
Route::prefix('modulos/submodulos')->group(function () {
    Route::get('', [SubmoduloController::class, 'admin_modulos_submodulos_all']);
    Route::get('/{ids}', [SubmoduloController::class, 'admin_modulos_submodulos_in']);
});

//Limpar Caches via Navegador - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::get('/clear-all-cache', function() {
    $retorno = '';

    //Limpar cache do aplicativo:
    Artisan::call('cache:clear');
    $retorno .= 'cache:clear'.'<br>';

    //Limpar cache de rota:
    Artisan::call('route:cache');
    $retorno .= 'route:cache'.'<br>';

    //Limpar cache de configuração:
    Artisan::call('config:cache');
    $retorno .= 'config:cache'.'<br>';

    //Clear view cache:
    Artisan::call('view:clear');
    $retorno .= 'view:clear'.'<br>';

    //Limpe todo o aplicativo de todos os tipos de cache:
    Artisan::call('optimize:clear');
    $retorno .= 'optimize:clear'.'<br>';

    echo $retorno;
});
//Limpar Caches via Navegador - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''






//Rotas de Testes
require __DIR__ . '/zzz_rotas_testes.php';
