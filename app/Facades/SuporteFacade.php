<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SuporteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facade-suporte';
    }
}
