<?php

namespace App\Providers;

use App\Services\CurrencyService;
use App\Services\DocumentService;
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
        //
    }

    protected function overrideConfigValues()
    {
        $config = [];
//        if (config('settings.skin')) {
//            $config['backpack.base.skin'] = config('settings.skin');
//        }


        if (config('backpack.base.show_powered_by')) {
            $config['backpack.base.show_powered_by'] = true;
        }
        else {
            $config['backpack.base.show_powered_by'] = false;
        }

        config($config);
    }
}
