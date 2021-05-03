<?php

namespace App\Observers;

use App\Http\Controllers\CatalogProductController;
use App\Models\CatalogProduct;
use App\Services\AliasService;

class CatalogProductObserver
{
    /**
     * Handle the CatalogProduct "created" event.
     *
     * @param \App\Models\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function created(CatalogProduct $catalogProduct)
    {
        (new AliasService)->update([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);
    }

    /**
     * Handle the CatalogProduct "updated" event.
     *
     * @param \App\Models\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function updated(CatalogProduct $catalogProduct)
    {
        (new AliasService)->update([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);
    }

    /**
     * Handle the CatalogProduct "deleted" event.
     *
     * @param \App\Models\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function deleted(CatalogProduct $catalogProduct)
    {
        (new AliasService)->remove([
            'slug'       => $catalogProduct->slug,
            'controller' => CatalogProductController::class,
            'model'      => CatalogProduct::class,
            'model_id'   => $catalogProduct->id
        ]);
    }

    /**
     * Handle the CatalogProduct "restored" event.
     *
     * @param \App\Models\CatalogProduct $catalogProduct
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
     * @param \App\Models\CatalogProduct $catalogProduct
     *
     * @return void
     */
    public function forceDeleted(CatalogProduct $catalogProduct)
    {
        //
    }
}
