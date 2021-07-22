<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CatalogProductProductsRequest;
use App\Http\Resources\CatalogProductThumbResource;
use App\Repository\CatalogProductRepository;

class CatalogProductController extends Controller
{
    public function index(CatalogProductProductsRequest $request, CatalogProductRepository $productRepository)
    {
        $inputs   = $request->all();
        $products = $productRepository->getProducts($inputs);

        return CatalogProductThumbResource::collection($products);
    }
}
