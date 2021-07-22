<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CatalogCategoryRequest;
use App\Http\Resources\CatalogProductCollection;
use App\Http\Resources\CatalogProductThumbResource;
use App\Repository\CatalogProductRepository;
use Illuminate\Http\Request;

class CatalogCategoryController extends Controller
{
    public function products(CatalogCategoryRequest $request, $id, CatalogProductRepository $productRepository)
    {
        $products = $productRepository->getProductsForPageByCategoryId($id, $request->all());

        return CatalogProductCollection::make(compact('products'));
    }
}
