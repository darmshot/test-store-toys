<?php

namespace App\Observers;

use App\Http\Controllers\CatalogManufacturerController;
use App\Models\CatalogManufacturer;
use App\Services\AliasService;

class CatalogManufacturerObserver
{
    /**
     * Handle the CatalogManufacturer "created" event.
     *
     * @param \App\Models\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function created(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->update([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "updated" event.
     *
     * @param \App\Models\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function updated(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->update([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "deleted" event.
     *
     * @param \App\Models\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function deleted(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->remove([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "restored" event.
     *
     * @param \App\Models\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function restored(CatalogManufacturer $catalogManufacturer)
    {
        //
    }

    /**
     * Handle the CatalogManufacturer "force deleted" event.
     *
     * @param \App\Models\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function forceDeleted(CatalogManufacturer $catalogManufacturer)
    {
        //
    }
}
