<?php


namespace App\Services;


use App\Models\Admin\CatalogProduct;

class CatalogProductEventService
{
    static private $attributes;
    static private $categories;

    public static function setProductAttributes(CatalogProduct &$product)
    {
        $productAttributes = $product->fProductAttributes;

        if ($productAttributes) {
            $syncAttributes = collect($productAttributes)->filter()->mapWithKeys(function ($item) {
                if (empty($item['id']) || empty($item['value'])) {
                    return [];
                }

                return [$item['id'] => ['value' => $item['value']]];
            })->all();

            self::$attributes = $syncAttributes;
        }

        $product->offsetUnset('fake_product_attributes');
    }

    public static function updateProductAttribute(CatalogProduct &$product)
    {
        if (self::$attributes) {
            $product->productAttributes()->sync(self::$attributes);
        } else {
            $product->productAttributes()->detach();
        }
    }

    public static function setCategories(CatalogProduct &$product)
    {

        $categories   = $product->fCategories;
        $mainCategory = $product->fMainCategory;

        if ($categories || $mainCategory) {

            $syncCategories = collect($categories)->push($mainCategory)
                                                  ->unique()
                                                  ->filter()
                                                  ->mapWithKeys(function ($item) use ($mainCategory) {
                                                      $isMainCategory = ($item == $mainCategory) ? true : false;
                                                      $result         = [$item => ['main_category' => $isMainCategory]];

                                                      return $result;
                                                  })->all();

            self::$categories = $syncCategories;
        }

        $product->offsetUnset('fake_categories');
        $product->offsetUnset('fake_main_category');
    }

    public static function updateCategories(CatalogProduct &$product)
    {
        $productCategories = $product->categories();
        $productCategories->detach();
        if (self::$categories) {
            $productCategories->attach(self::$categories);
        }
    }
}
