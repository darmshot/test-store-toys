<?php


namespace App\Services\Parsers\Builders;


use App\Models\Admin\CatalogProduct;
use App\Services\Parsers\Contracts\BuilderContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductBuild implements BuilderContract
{
    /**
     * @var CatalogProduct|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $modelProduct;
    /**
     * @var array
     */
    private $fields;


    public function __construct()
    {
        $this->modelProduct = app(CatalogProduct::class);

    }

    public function setFields(array $fields): BuilderContract
    {
        $this->fields = $fields;

        return $this;
    }

    public function getId(): ?int
    {
        if (empty($this->fields['sku'])) {
            return null;
        }

        $sku = Str::limit($this->fields['sku'], 50);

        $id = null;

        $query = $this->modelProduct->where('sku', $sku)->first();

        if ($query) {
            $id = $query->id;
        }

        return $id;
    }

    public function getIdInsertOrUpdate(): ?int
    {
        if (empty($this->fields['title']) || empty($this->fields['sku'])) {
            return null;
        }

        $sku = Str::limit($this->fields['sku'], 50);

        $cacheKey = 'attribute_build_id.' . Str::of($sku)->pipe('md5');

        $id = Cache::get($cacheKey, function () use ($sku, $cacheKey) {
            $query = $this->modelProduct->where('sku', $sku)->first();

            if ($query) {
                Cache::put($cacheKey, $query->id, 3600);

                return $query->id;
            } else {
                return null;
            }
        });

        if ($id == null) {
            $title = Str::limit($this->fields['title'], 50);

            $product = $this->modelProduct::create([
                'title'           => $title,
                'meta_title'      => $this->fields['meta_title'] ?? null,
                'description'     => $this->fields['description'] ?? null,
                'manufacturer_id' => $this->fields['manufacturer_id'] ?? null,
                'sku'             => $this->fields['sku'] ?? null,
            ]);
            $id      = $product->id;

            $syncCategories = $this->getSyncCategories();
            $syncAttributes = $this->getSyncAttributes();

            if ($syncCategories) {
                $product->categories()->attach($syncCategories);
            }

            if ($syncAttributes) {
                $product->productAttributes()->attach($syncAttributes);
            }

            if ( ! empty($this->fields['product_load_images'])) {
                $product->productLoadImages()->create([
                    'images' => $this->fields['product_load_images']
                ]);
            }

            Cache::put($cacheKey, $id, 3600);
        } else {
            $this->update($id);
        }

        return $id;
    }


    private function update(int $id)
    {
        $product = $this->modelProduct->find($id);

//            $product->meta_title = $this->fields['meta_title'] ?? null;
//            $product->save();

            $syncCategories = $this->getSyncCategories();
            $syncAttributes = $this->getSyncAttributes();

            if ($syncCategories && $product) {
                $product->categories()->detach();
                $product->categories()->attach($syncCategories);
            }

            if ($syncAttributes && $product) {
                $product->productAttributes()->detach();
                $product->productAttributes()->attach($syncAttributes);
            }

//            if ( ! empty($this->fields['product_load_images'])) {
//                $product->productLoadImages()->updateOrCreate(['product_id' => $id], [
//                    'images' => $this->fields['product_load_images']
//                ]);
//            }
    }


    private function getSyncCategories()
    {
        if ( ! empty($this->fields['main_category_id'])) {
            $mainCategoryId = $this->fields['main_category_id'];
            $syncCategories = [$mainCategoryId => ['main_category' => true]];
        } else {
            $syncCategories = [];
        }

        return $syncCategories;
    }

    private function getSyncAttributes()
    {
        if (isset($this->fields['attributes'])) {
            $syncAttributes = collect($this->fields['attributes'])->filter()->mapWithKeys(function ($item) {
                if (empty($item['id']) || empty($item['value'])) {
                    return [];
                }

                return [$item['id'] => ['value' => $item['value']]];
            })->all();

        } else {
            $syncAttributes = [];
        }

        return $syncAttributes;
    }
}
