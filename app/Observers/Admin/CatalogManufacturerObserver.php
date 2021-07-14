<?php

namespace App\Observers\Admin;

use App\Http\Controllers\CatalogManufacturerController;
use App\Models\Admin\CatalogManufacturer;
use App\Services\AliasService;

class CatalogManufacturerObserver
{
    /**
     * Handle the CatalogManufacturer "created" event.
     *
     * @param \App\Models\Admin\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function created(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => \App\Models\CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "updated" event.
     *
     * @param \App\Models\Admin\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function updated(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => \App\Models\CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "deleted" event.
     *
     * @param \App\Models\Admin\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function deleted(CatalogManufacturer $catalogManufacturer)
    {
        (new AliasService)->remove([
            'slug'       => $catalogManufacturer->slug,
            'controller' => CatalogManufacturerController::class,
            'model'      => \App\Models\CatalogManufacturer::class,
            'model_id'   => $catalogManufacturer->id
        ]);
    }

    /**
     * Handle the CatalogManufacturer "restored" event.
     *
     * @param \App\Models\Admin\CatalogManufacturer $catalogManufacturer
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
     * @param \App\Models\Admin\CatalogManufacturer $catalogManufacturer
     *
     * @return void
     */
    public function forceDeleted(CatalogManufacturer $catalogManufacturer)
    {
        //
    }
}
