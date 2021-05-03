<?php

namespace App\Providers;

use App\Models\CatalogCategory;
use App\Models\CatalogManufacturer;
use App\Models\CatalogProduct;
use App\Observers\CatalogCategoryObserver;
use App\Observers\CatalogManufacturerObserver;
use App\Observers\CatalogProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        CatalogCategory::observe(CatalogCategoryObserver::class);
        CatalogProduct::observe(CatalogProductObserver::class);
        CatalogManufacturer::observe(CatalogManufacturerObserver::class);
    }
}
