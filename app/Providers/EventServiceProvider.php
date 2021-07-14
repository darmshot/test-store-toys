<?php

namespace App\Providers;

use App\Models\Admin\CatalogCategory;
use App\Models\Admin\CatalogManufacturer;
use App\Models\Admin\CatalogProduct;
use App\Models\Admin\Page;
use App\Observers\Admin\CatalogCategoryObserver;
use App\Observers\Admin\CatalogManufacturerObserver;
use App\Observers\Admin\CatalogProductObserver;
use App\Observers\Admin\PageObserver;
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
        Page::observe(PageObserver::class);
    }
}
