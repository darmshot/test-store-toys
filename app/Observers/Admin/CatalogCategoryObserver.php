<?php

namespace App\Observers\Admin;

use App\Http\Controllers\CatalogCategoryController;
use App\Models\Admin\CatalogCategory;
use App\Services\AliasService;
use Illuminate\Support\Facades\Cache;

class CatalogCategoryObserver
{
    /**
     * Handle the CatalogCategory "created" event.
     *
     * @param \App\Models\Admin\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function created(CatalogCategory $catalogCategory)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => \App\Models\CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);
    }

    /**
     * Handle the CatalogCategory "updated" event.
     *
     * @param \App\Models\Admin\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function updated(CatalogCategory $catalogCategory)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => \App\Models\CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);

        Cache::tags('catalog_category.' . $catalogCategory->id)->clear();
    }

    /**
     * Handle the CatalogCategory "deleted" event.
     *
     * @param \App\Models\Admin\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function deleted(CatalogCategory $catalogCategory)
    {
        (new AliasService)->remove([
            'slug'       => $catalogCategory->slug,
            'controller' => CatalogCategoryController::class,
            'model'      => \App\Models\CatalogCategory::class,
            'model_id'   => $catalogCategory->id
        ]);

        Cache::tags('catalog_category.' . $catalogCategory->id)->clear();
    }

    /**
     * Handle the CatalogCategory "restored" event.
     *
     * @param \App\Models\Admin\CatalogCategory $catalogCategory
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
     * @param \App\Models\Admin\CatalogCategory $catalogCategory
     *
     * @return void
     */
    public function forceDeleted(CatalogCategory $catalogCategory)
    {
        //
    }
}
