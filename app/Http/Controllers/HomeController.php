<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'home')->first();

        if ( ! $page) {
            abort(404, 'Please go back to our <a href="' . url('') . '">homepage</a>.');
        }


        \Document::setTitle($page->extras['meta_title'] ?? $page->title);
        \Document::setDescription($page->extras['meta_description'] ?? null);

//        dd($page->extras);
        return view('pages.home', compact('page'));
    }
}
