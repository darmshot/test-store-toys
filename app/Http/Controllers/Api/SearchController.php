<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogProductCollection;
use App\Http\Resources\SearchAutocompleteResource;
use App\Models\CatalogProduct;
use App\Repository\CatalogProductRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, CatalogProductRepository $productRepository)
    {
        $query = $request->input('q');

        if ($query === null) {
            abort(400);
        }
//        $query = '№ЕАЭС BY/112 02.02. 019 05107 до'; // <-- Change the query for testing.

        $products = CatalogProduct::search($query)->take(10)->get();

        return SearchAutocompleteResource::collection($products);
    }
}
