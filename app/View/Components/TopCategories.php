<?php

namespace App\View\Components;

use App\Repository\CatalogCategoryRepository;
use Illuminate\View\Component;

class TopCategories extends Component
{
    private CatalogCategoryRepository $catalogRepository;
    private $ids;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ids, CatalogCategoryRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
        $this->ids = $ids;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = $this->catalogRepository->getTopCategoriesByIds($this->ids);
        return view('components.top-categories',compact('categories'));
    }
}
