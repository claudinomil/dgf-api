<?php

namespace App\Providers;

use App\Services\Transacoes;
use Illuminate\Support\ServiceProvider;

class TransacaoProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('transacoes-sistema', function () {
            return new Transacoes();
        });
    }
}
