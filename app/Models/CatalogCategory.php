<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;

class CatalogCategory extends Model
{
    use NodeTrait;
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Get all menu items, in a hierarchical collection.
     * Only supports 2 levels of indentation.
     */
    public static function getTree()
    {
        $menu = self::orderBy('lft')->select(['id', 'title', 'parent_id', 'lft', 'slug'])->get();

        if ($menu->count()) {
            foreach ($menu as $k => $menu_item) {
                $menu_item->children = collect([]);

                foreach ($menu as $i => $menu_subitem) {
                    if ($menu_subitem->parent_id == $menu_item->id) {
                        $menu_item->children->push($menu_subitem);

                        // remove the subitem for the first level
                        $menu = $menu->reject(function ($item) use ($menu_subitem) {
                            return $item->id == $menu_subitem->id;
                        });
                    }
                }
            }
        }


        foreach ($menu as $key => $item) {
            $path            = $item->slug;
            $menu[$key]->url = url($path);
            foreach ($item->children as $keyLvl2 => $lvl2) {
                $pathLvl2                      = $path . '/' . $lvl2->slug;
                $item->children[$keyLvl2]->url = url($pathLvl2);

                foreach ($lvl2->children as $keyLvl3 => $lvl3) {
                    $pathLvl3                      = $path . '/' . $lvl3->slug;
                    $lvl2->children[$keyLvl3]->url = url($pathLvl3);
                }
            }
        }

        return $menu;
    }


    public function getLftName()
    {
        return 'lft';
    }

    public function getRgtName()
    {
        return 'rgt';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(CatalogProduct::class, 'catalog_product_category', 'category_id', 'product_id');
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
    public function getPathAttribute()
    {
        //get cache
        $path = Cache::tags('catalog_category.' . $this->id)->get('path');

        if (empty($path)) {
            if ($this->slug) {
                $slugs   = [];
                $slugs[] = $this->slug;

                $parent = $this->parent();

                while ($parent = $parent->select(['id', 'parent_id', 'slug'])->first()) {
                    if ( ! $parent->slug) {
                        return null;
                    }

                    $slugs[] = $parent->slug;
                    $parent  = $parent->parent();
                }

                $path = implode('/', array_reverse($slugs));
                Cache::tags('catalog_category.' . $this->id)->forever('path', $path);
            } else {
                return null;
            }
        }


        return $path;
    }

    public function getUrlAttribute()
    {
        $path = $this->getPathAttribute();

        return $path && config('catalog.seo_url') ? url($path) : route('catalog.category.show', ['id' => $this->id]);
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
