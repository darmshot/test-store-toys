<?php


namespace App\Facades;


use App\Services\FunctionsService;

class FunctionsFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return FunctionsService::class;
    }
}
