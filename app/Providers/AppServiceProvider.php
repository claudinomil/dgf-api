<?php

namespace App\Providers;

use App\Services\SuporteService;
use App\Services\Transacoes;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Facade Service Transacoes
        $this->app->bind('transacoes-sistema', function () {
            return new Transacoes();
        });

        //Facade SuporteFacade
        $this->app->bind('facade-servico', function () {
            return new SuporteService();
        });
    }

    public function boot(): void
    {
        //
    }
}
