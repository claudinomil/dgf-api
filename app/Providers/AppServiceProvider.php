<?php

namespace App\Providers;

use App\Services\SuporteService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Services\Transacoes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Facade Service Transacoes
        $this->app->bind('transacoes-sistema', function () {
            return new Transacoes();
        });

        //Facade SuporteFacade
        $this->app->bind('facade-suporte', function () {
            return new SuporteService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::hashClientSecrets();
    }
}
