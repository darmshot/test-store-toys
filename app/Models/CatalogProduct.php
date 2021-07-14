<?php

namespace App\Models;

use App\Services\Thumb\Templates\ProductThumbTemplate;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Thumb;
use Laravel\Scout\Searchable;

class CatalogProduct extends Model
{
    use HasFactory;

//    use Cachable;
    use Searchable;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guarded = ['id'];
    protected $table = 'catalog_products';
    const PUBLISH = 'publish';
    protected $casts = ['images' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

//        static::saved(function ($model) {
//            $model->articles->filter(function ($item) {
//                return $item->shouldBeSearchable();
//            })->searchable();
//        });
    }

    public function getStockStatus()
    {

        if ($this->quantity > 0) {
            $stockStatus = $this->stockStatus;
            $result      = $stockStatus->name ?? null;
        } else {
            $outOfStockStatus = $this->outOfStockStatus;
            $result           = $outOfStockStatus->name ?? null;
        }

        return $result;
    }

    public function getDescription()
    {
        $description = html_entity_decode($this->description, ENT_QUOTES, 'UTF-8');
        $description = str_replace('<iframe ', '<div class="iframe-wrap"><iframe ', $description);
        $description = str_replace('</iframe>', '</iframe></div>', $description);

        return $description;
    }

    public function getPrice()
    {
        return $this->price ? \Currency::format($this->price, 'byn') : null;
    }

    public function getPriceSpecial()
    {
        $special = $this->price_special ? \Currency::format($this->price_special, 'byn') : null;

        return $special;
    }

    public function getPriceSpecialPercent()
    {
        if ($this->price_special && $this->price) {
            $result = round(100 - ($this->price_special / ($this->price / 100))) . '%';
        } else {
            $result = null;
        }

        return $result;
    }

    public function toSearchableArray()
    {


        $array = $this->toArray();

        // Applies Scout Extended default transformations:
        $array = $this->transform($array);

        // Add an extra attribute:
        $array['added_month'] = substr($array['created_at'], 0, 7);

        return $array;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function manufacturer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CatalogManufacturer::class, 'manufacturer_id');
    }

    public function stockStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CatalogStatus::class, 'stock_status_id');
    }

    public function outOfStockStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CatalogStatus::class, 'out_of_stock_status_id');
    }

    public function categories()
    {
        return $this->belongsToMany(CatalogCategory::class, 'catalog_product_category', 'product_id', 'category_id');
    }

    public function productAttributes()
    {
        return $this
            ->belongsToMany(CatalogAttribute::class, 'catalog_attribute_value_product', 'product_id', 'attribute_id')
            ->withPivot('value')
            ->select('catalog_attributes.id',
                'catalog_attributes.title',
                'catalog_attributes.slug as attribute_slug',
                'catalog_attribute_value_product.value');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(self::class, 'catalog_product_related', 'product_id', 'related_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getThumbsAttribute(): array
    {
        if ($this->images) {
            $data = array_slice($this->images, 0, 2);;
        } else {
            $data = array();
        }

        $images = \Thumb::template(ProductThumbTemplate::class)->get($data);

        return $images;
    }

    public function getThumbAttribute(): array
    {
        return $this->thumbs[0] ?? [];
    }

    public function getGalleryAttribute()
    {
        $previewDesktop = \Thumb::template(\App\Services\Thumb\Templates\ProductGalleryPreviewDesktopTemplate::class)->get($this->images);
        $previewMobile  = \Thumb::template(\App\Services\Thumb\Templates\ProductGalleryPreviewMobileTemplate::class)->get($this->images);
        $fullScreen     = \Thumb::template(\App\Services\Thumb\Templates\ProductGalleryFullScreenTemplate::class)->get($this->images);

        $gallery = [];
        $count   = count($previewDesktop);
        $i       = 0;

        while ($i < $count) {
            $gallery[$i]['preview_desktop'] = $previewDesktop[$i];
            $gallery[$i]['preview_mobile']  = $previewMobile[$i];
            $gallery[$i]['full_screen']     = $fullScreen[$i];
            $i ++;
        }

        return $gallery;
    }

    public function getPathAttribute()
    {
        $path = Cache::tags('catalog_product.' . $this->id)->get('path');

        if (empty($path)) {
            if ($this->slug) {
                $mainCategory = $this->categories()->wherePivot('main_category', 1)->first();

                $path = null;
                if ($mainCategory) {
                    $categoryPath = $mainCategory->path;
                    $path         = $categoryPath . '/' . $this->slug;

                    Cache::tags('catalog_product.' . $this->id)->forever('path', $path);
                } else {
                    return null;
                }
            }

        }

        return $path;
    }

    public function getUrlAttribute()
    {
        $path = $this->getPathAttribute();

        return $path && config('catalog.seo_url') ? url($path) : route('catalog.product.show', ['id' => $this->id]);
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
