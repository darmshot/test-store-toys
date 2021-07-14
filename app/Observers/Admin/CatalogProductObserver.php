<?php

namespace App\Observers\Admin;

use App\Http\Controllers\CatalogProductController;
use App\Models\Admin\CatalogProduct;
use App\Services\AliasService;
use App\Services\CatalogProductEventService;
use Illuminate\Support\Facades\Cache;

class CatalogProductObserver
{

    /**
     * @var mixed
     */
    private $test;

    public function creating(CatalogProduct $catalogProduct)
    {
        CatalogProductEventService::setProductAttributes($catalogProduct);
        CatalogProductEventService::setCategories($catalogProduct);
    }

    /**
     * Handle the CatalogProduct "created" event.
     *
     * @param \App\Models\Admin\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function created(CatalogProduct $catalogProduct)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => \App\Models\CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);

        CatalogProductEventService::updateProductAttribute($catalogProduct);
        CatalogProductEventService::updateCategories($catalogProduct);

    }

    public function updating(CatalogProduct $catalogProduct)
    {
        CatalogProductEventService::setProductAttributes($catalogProduct);
        CatalogProductEventService::setCategories($catalogProduct);


    }

    /**
     * Handle the CatalogProduct "updated" event.
     *
     * @param \App\Models\Admin\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function updated(CatalogProduct $catalogProduct)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => \App\Models\CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);

        CatalogProductEventService::updateProductAttribute($catalogProduct);
        CatalogProductEventService::updateCategories($catalogProduct);

        Cache::tags('catalog_product.' . $catalogProduct->id)->clear();
    }

    /**
     * Handle the CatalogProduct "deleted" event.
     *
     * @param \App\Models\Admin\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function deleted(CatalogProduct $catalogProduct)
    {
        (new AliasService)->remove([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => \App\Models\CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);

        Cache::tags('catalog_product.' . $catalogProduct->id)->clear();
    }

    /**
     * Handle the CatalogProduct "restored" event.
     *
     * @param \App\Models\Admin\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function restored(CatalogProduct $catalogProduct)
    {
        //
    }

    /**
     * Handle the CatalogProduct "force deleted" event.
     *
     * @param \App\Models\Admin\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function forceDeleted(CatalogProduct $catalogProduct)
    {
        //
    }
}
