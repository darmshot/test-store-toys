<?php


namespace App\Facades;


class CurrencyFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'currency';
    }
}
