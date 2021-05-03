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

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/about', function () {
    return view('pages.default');
})->name('about');


Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/categories/{category_id}', function ($categoryId) {
        return view('catalog.category');
    })->name('category');


    Route::get('/products/{product_id}', function ($productId) {
        return view('catalog.product');
    })->name('product');
});




Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
     ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
