<?php

namespace App\Observers\Admin;

use App\Http\Controllers\PageController;
use App\Models\Admin\Page;
use App\Services\AliasService;

class PageObserver
{
    /**
     * Handle the CatalogManufacturer "created" event.
     *
     * @param \App\Models\Admin\CatalogManufacturer $page
     *
     * @return void
     */
    public function created(Page $page)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $page->slug,
            'controller' => PageController::class,
            'model'      => \App\Models\Page::class,
            'model_id'   => $page->id
        ]);
    }

    /**
     * Handle the Page "updated" event.
     *
     * @param \App\Models\Admin\Page $page
     *
     * @return void
     */
    public function updated(Page $page)
    {
        (new AliasService)->updateOrCreate([
            'slug'       => $page->slug,
            'controller' => PageController::class,
            'model'      => \App\Models\Page::class,
            'model_id'   => $page->id
        ]);
    }

    /**
     * Handle the Page "deleted" event.
     *
     * @param \App\Models\Admin\Page $page
     *
     * @return void
     */
    public function deleted(Page $page)
    {
        (new AliasService)->remove([
            'slug'       => $page->slug,
            'controller' => PageController::class,
            'model'      => \App\Models\Page::class,
            'model_id'   => $page->id
        ]);
    }

    /**
     * Handle the Page "restored" event.
     *
     * @param \App\Models\Admin\Page $page
     *
     * @return void
     */
    public function restored(Page $page)
    {
        //
    }

    /**
     * Handle the Page "force deleted" event.
     *
     * @param \App\Models\Admin\Page $page
     *
     * @return void
     */
    public function forceDeleted(Page $page)
    {
        //
    }
}
