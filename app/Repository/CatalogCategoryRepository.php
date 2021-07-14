<?php


namespace App\Repository;


use App\Models\CatalogCategory;

class CatalogCategoryRepository
{
    public function getTopCategoriesByIds($ids)
    {
      return  CatalogCategory::with(['children'=>function($query){
          $query->limit(5);
      }])->whereIn('id',$ids)
//                             ->select('id','title','slug')
                             ->get();
    }
}
