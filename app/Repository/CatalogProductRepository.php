<?php


namespace App\Repository;


use App\Models\CatalogCategory;
use App\Models\CatalogProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CatalogProductRepository
{
    public function getProducts(array $data): \Illuminate\Database\Eloquent\Collection
    {

        $type = $data['type'] ?? null;


        switch ($type) {
            case 'ids':
                $productIds = $data['ids'] ?? [];
                $result     = $this->getProductsByIds($productIds);
                break;
            case 'special':
                $result = $this->getSpecialProducts();
                break;
            case 'related':
                $productId = $data['product_id'] ?? null;
                $result    = $this->getRelatedProducts($productId);

                if ($result->isEmpty()) {
                    $result = $this->getRandProductsFromRelatedCategoriesByProductId($productId);
                }
        }

        return $result ?? \Illuminate\Database\Eloquent\Collection::make();
    }

    public function getProductsByIds(array $ids): \Illuminate\Database\Eloquent\Collection
    {
        return CatalogProduct::with([
            'manufacturer:title,id',
            'stockStatus'
        ])->whereIn('id', $ids)->where('status', CatalogProduct::PUBLISH)
//                             ->select('stock_status_id', 'out_of_stock_status_id', 'manufacturer_id', 'title' ,'quantity','images', 'price', 'sku', 'id')
                             ->limit(20)
                             ->get();
    }

    public function getSpecialProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return \Illuminate\Database\Eloquent\Collection::make();
    }

    public function getRelatedProducts(int $productId): \Illuminate\Database\Eloquent\Collection
    {
        $queryProduct = CatalogProduct::where('id', $productId)->with([
            'relatedProducts' => function ($query) {
                $query->with([
                    'manufacturer:title,id',
                    'stockStatus'
                ])->where('status', CatalogProduct::PUBLISH)->limit(20);
            }
        ])->select('id')
                                      ->first();

        $products = $queryProduct->relatedProducts ?? \Illuminate\Database\Eloquent\Collection::make();

        return $products;
    }

    public function getRandProductsFromRelatedCategoriesByProductId(int $productId): \Illuminate\Database\Eloquent\Collection
    {
        $queryCategories = DB::select("select category_id from catalog_product_category where product_id = {$productId}");

        if ($queryCategories) {
            $categoryIds = collect($queryCategories)->pluck('category_id')->all();
        } else {
            $categoryIds = [];
        }

        if ($categoryIds) {
            $products = CatalogProduct::with([
                'manufacturer:title,id',
                'stockStatus'
            ])->whereHas('categories', function (Builder $query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->where('status', CatalogProduct::PUBLISH)
                                      ->inRandomOrder()
                                      ->limit(20)
                                      ->get();
        } else {
            $products = \Illuminate\Database\Eloquent\Collection::make();
        }

        return $products;
    }

    public function getProductsForPageByCategoryId(int $id, array $data = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $products = CatalogProduct::with(['manufacturer:title,id', 'stockStatus']);

//        CatalogCategory::descendants
        $categoriesIds = CatalogCategory::select('id')->descendantsAndSelf($id)->pluck('id')->all();
        if ( ! empty($data['limit'])) {
            $limit = $data['limit'];
        } else {
            $limit = 20;
        }

        if ( ! empty($data['page']) >= 2) {
            $offset = $data['page'] * $limit;
        } else {
            $offset = 0;
        }

        if ( ! empty($data['order'])) {
            $order = $data['order'];
        } else {
            $order = 'asc';
        }

        if ( ! empty($data['sort'])) {
            $sort = $data['sort'];
        } else {
            $sort = 'title';
        }

        $products = $products->whereHas('categories', function (Builder $query) use ($categoriesIds) {
            $query->whereIn('id',$categoriesIds);
        });

//        if($filter = $this->getFilterParams($data)){
//            foreach ($filter as $option) {
//                $offers = $offers
//                    ->whereExists(function ($query) use ($option) {
//                        $valuesId = array_keys($option->values);
//                        $query->select(DB::raw(1))
//                              ->from('catalog_filter_option_value_offer')
//                              ->whereColumn('catalog_filter_option_value_offer.offer_id', 'catalog_offers.id')
//                              ->where('catalog_filter_option_value_offer.option_id', $option->id)
//                              ->whereIn('catalog_filter_option_value_offer.value_id',$valuesId);
//                    });
//            }
//        }


        $products = $products->where('status', CatalogProduct::PUBLISH);

        $products = $products->offset($offset);
//                         ->limit($limit);

        $products = $products->orderBy($sort, $order);
//        $products = $products->select('id', 'slug', 'title', 'images');


        $products = $products->paginate($limit);

        return $products;

    }

    public function getProductsForPageBySearchQuery($data)
    {



    }
}
