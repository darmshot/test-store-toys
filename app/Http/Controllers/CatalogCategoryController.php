<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use Illuminate\Http\Request;

class CatalogCategoryController extends Controller
{
    public function show($id, CatalogCategory $category)
    {
        // if use route
        if($category->id == null){
            $category = $category::findOrFail($id);
        }

        \Document::setTitle($category->meta_title ?? $category->title);

        \Document::addScriptVar('category',['id'=>$category->id]);

        return view('catalog.category', compact('category'));
    }
}
