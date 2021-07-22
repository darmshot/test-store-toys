<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {

        $page = Page::where('template', 'template_search')->first();

        if ( ! $page) {
            abort(404, 'Please go back to our <a href="' . url('') . '">homepage</a>.');
        }


        \Document::setTitle($page->extras['meta_title'] ?? $page->title);
        \Document::setDescription($page->extras['meta_description'] ?? null);

        return view('pages.search', compact('page'));
    }
}
