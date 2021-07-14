<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('catalog/categories', 'CatalogCategoryCrudController');

    Route::crud('catalog/products', 'CatalogProductCrudController');
    Route::post('api/catalog/products/attributes',[\App\Http\Controllers\Admin\Api\CatalogProductController::class,'getAttributesAutocomplete']);
    Route::match(['post','get'],'api/catalog/products',[\App\Http\Controllers\Admin\Api\CatalogProductController::class,'index']);
    Route::match(['post','get'],'api/catalog/products/{id}',[\App\Http\Controllers\Admin\Api\CatalogProductController::class,'show']);

    Route::crud('catalog/manufacturers', 'CatalogManufacturerCrudController');

    Route::crud('catalog/statuses', 'CatalogStatusCrudController');

    Route::crud('catalog/attributes', 'CatalogAttributeCrudController');

    Route::crud('catalog/product-load-images', 'CatalogProductLoadImageCrudController');

    // Backpack\MenuCRUD
    Route::crud('menu-item', 'MenuItemCrudController');

    Route::crud('alias', 'AliasCrudController');

    Route::crud('page', 'PageCrudController');

}); // this should be the absolute last line of this file
