<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function show($id, \App\Models\Page $page)
    {
        // if use route try get by id
        if($page->id == null){
            $page = $page::findOrFail($id);
        }

        \Document::setTitle($page->meta_title);

        return view('pages.'.$page->template, compact('page'));
    }
}
