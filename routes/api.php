<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('catalog/products',[\App\Http\Controllers\Api\CatalogProductController::class,'index']);
Route::post('catalog/categories/{id}/products',[\App\Http\Controllers\Api\CatalogCategoryController::class,'products']);

Route::post('search',[\App\Http\Controllers\Api\SearchController::class,'index']);



//DEBUG
Route::get('catalog/categories/{id}/products',[\App\Http\Controllers\Api\CatalogCategoryController::class,'products']);
Route::get('catalog/products',[\App\Http\Controllers\Api\CatalogProductController::class,'index']);
Route::get('search',[\App\Http\Controllers\Api\SearchController::class,'index']);

