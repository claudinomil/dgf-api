<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Transacoes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'transacoes-sistema';
    }
}
