<?php

namespace App\View\Components;

use App\Models\CatalogCategory;
use App\Models\MenuItem;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CatalogCategory $category)
    {
        $this->categories = $category::getTree();
//        dd($this->categories);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.main-menu');
    }
}
