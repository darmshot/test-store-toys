<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('about', function () {
    return view('pages.default');
})->name('about');


Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('categories/{id}', [
        \App\Http\Controllers\CatalogCategoryController::class,
        'show'
    ])->name('category.show');
    Route::get('products/{id}', [\App\Http\Controllers\CatalogProductController::class, 'show'])->name('product.show');
});


Route::get('search', [\App\Http\Controllers\SearchController::class, 'index']);


Route::post('cart', [\App\Http\Controllers\CartController::class, 'index']);
Route::post('cart/add', [\App\Http\Controllers\CartController::class, 'add']);
Route::post('cart/remove', [\App\Http\Controllers\CartController::class, 'remove']);


Route::get('checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::get('checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('checkout/confirm', [\App\Http\Controllers\CheckoutController::class, 'confirm'])->name('checkout.confirm');


Route::get('test/parser', [\App\Http\Controllers\TestController::class, 'startTestOne']);
Route::get('test/mail', [\App\Http\Controllers\TestController::class, 'mail']);
Route::get('test/nested', [\App\Http\Controllers\TestController::class, 'nested']);


Route::get('{alias}/{subs?}', ['uses' => '\App\Http\Controllers\AliasController'])
     ->where(['alias' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);


//Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
//     ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
