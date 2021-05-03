<?php

namespace App\Observers;

use App\Http\Controllers\CatalogCategoryController;
use App\Models\CatalogCategory;
use App\Services\AliasService;

class CatalogCategoryObserver
{
    /**
     * Handle the CatalogCategory "created" event.
     *
     * @param \App\Models\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function created(CatalogCategory $catalogCategory)
    {
        (new AliasService)->update([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);
    }

    /**
     * Handle the CatalogCategory "updated" event.
     *
     * @param \App\Models\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function updated(CatalogCategory $catalogCategory)
    {
        (new AliasService)->update([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);
    }

    /**
     * Handle the CatalogCategory "deleted" event.
     *
     * @param \App\Models\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function deleted(CatalogCategory $catalogCategory)
    {
        (new AliasService)->remove([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);
    }

    /**
     * Handle the CatalogCategory "restored" event.
     *
     * @param \App\Models\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function restored(CatalogCategory $catalogCategory)
    {
        //
    }

    /**
     * Handle the CatalogCategory "force deleted" event.
     *
     * @param \App\Models\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function forceDeleted(CatalogCategory $catalogCategory)
    {
        //
    }
}
