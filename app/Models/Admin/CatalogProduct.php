<?php

namespace App\Models\Admin;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class CatalogProduct extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'catalog_products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'manufacturer_id',
        'meta_keywords',
        'meta_description',
        'meta_title',
        'slug',
        'price_special',
        'price',
        'sku',
        'status',
        'description',
        'title',
        'images',
        'fake_product_attributes',
        'fake_categories',
        'fake_main_category',
    ];
    /**
     * @var mixed|null
     */
    public $fMainCategory = null;
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ['images' => 'array'];
    /**
     * @var mixed|null
     */
    public $fCategories = [];
    /**
     * @var array|mixed
     */
    public $fProductAttributes;


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function categories()
    {
        return $this->belongsToMany(CatalogCategory::class, 'catalog_product_category', 'product_id', 'category_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(CatalogManufacturer::class, 'manufacturer_id');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(self::class, 'catalog_product_related', 'product_id', 'related_id');
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

    public function productLoadImages()
    {
        return $this->hasOne(CatalogProductLoadImage::class,'product_id');
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
    public function getFakeProductAttributesAttribute()
    {
        return $this->attributes['fake_product_attributes'] ?? $this->productAttributes()->get()->toJson();
    }

    public function getFakeMainCategoryAttribute()
    {
        return $this->categories()->wherePivot('main_category', true)->first();
    }


    public function getFakeCategoriesAttribute()
    {
        return $this->categories()->get();
    }

    public function getMainCategoryAttribute()
    {
        return $this->categories()->wherePivot('main_category', true)->first();
    }

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        return $this->title;
    }

    public function getThumbAttribute()
    {
        return $this->images[0] ?? null;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setFakeProductAttributesAttribute($value)
    {
        if ($value) {
            $this->fProductAttributes = json_decode($value, true);
        } else {
            $this->fProductAttributes = [];
        }

        return $this->attributes['fake_product_attributes'] = $value;
    }

    public function setFakeMainCategoryAttribute($value)
    {
        if ($value) {
            $this->fMainCategory = $value;
        } else {
            $this->fMainCategory = null;
        }
    }

    public function setFakeCategoriesAttribute($value)
    {
        if ($value) {
            $this->fCategories = $value;
        } else {
            $this->fCategories = [];
        }
    }
}
