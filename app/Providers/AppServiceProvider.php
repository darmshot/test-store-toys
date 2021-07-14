<?php

namespace App\Providers;

use App\Services\CurrencyService;
use App\Services\DocumentService;
use App\View\Components\ChooseAge;

use App\View\Components\TopCategories;
use App\View\Composers\DocumentVarsComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('document', DocumentService::class);
        $this->app->singleton('currency', CurrencyService::class);

//        $this->overrideConfigValues();


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::componentNamespace('App\\View\\Components','app');
        View::composer('app', DocumentVarsComposer::class);

    }

    protected function overrideConfigValues()
    {
        $config = [];
//        if (config('settings.skin')) {
//            $config['backpack.base.skin'] = config('settings.skin');
//        }


        if (config('backpack.base.show_powered_by')) {
            $config['backpack.base.show_powered_by'] = true;
        } else {
            $config['backpack.base.show_powered_by'] = false;
        }

        config($config);
    }
}
