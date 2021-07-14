<?php

namespace App\Http\Controllers;

use App\Models\CatalogProduct;

class CatalogProductController extends Controller
{
    public function show($id, CatalogProduct $product)
    {
        if ($product->id == null) {
            $product = $product::findOrFail($id);
        }

        \Document::setTitle($product->meta_title ?? $product->title);

        \Document::addScriptVar('product', ['id' => $product->id, 'gallery' => $product->gallery]);

        return view('catalog.product', compact('product'));
    }
}
