<?php


namespace App\Facades;


use App\Services\Thumb\ThumbService;

class ThumbFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return ThumbService::class;
    }
}
