<?php


namespace App\Services\Parsers\Builders;


use App\Models\Admin\CatalogCategory;
use App\Services\Parsers\Contracts\BuilderContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryBuild implements BuilderContract
{

    /**
     * @var array
     */
    private $fields;
    /**
     * @var CatalogCategory|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $modelCategory;

    public function __construct()
    {
        $this->modelCategory = app(CatalogCategory::class);
    }

    public function getId(): ?int
    {

        if (empty($this->fields['path'])) {
            return null;
        }

        $path = $this->fields['path'];

        $count    = count($path);
        $i        = 0;
        $parentId = null;

        while ($count > $i) {
            $name = $path[$i];
            $id   = $this->getCategoryIdByName($name, $parentId);

            if ($id == null) {
                break;
            }

            $parentId = $id;

            $i ++;
        }

        $id = $parentId;


        return $id;
    }


    public function getIdInsertOrUpdate(): ?int
    {
        if (empty($this->fields['path'])) {
            return null;
        }
        $id = null;

        $path     = $this->fields['path'];
        $count    = count($path);
        $i        = 0;
        $parentId = null;

        while ($count > $i) {
            $name = Str::limit($path[$i], 50);

            $id = $this->getCategoryIdByName($name, $parentId);

            if ($id == null) {
                $id = $this->createCategoryByName($name, $parentId);
            }

            $parentId = $id;

            if ($id == null) {
                break;
            }
            $i ++;
        }

        return $id;
    }

    public function setFields(array $fields): BuilderContract
    {
        $this->fields = $fields;

        return $this;
    }

    private function getCategoryIdByName(string $name, ?int $parentId): ?int
    {
        $cacheKey = 'attribute_build_id.' . Str::of($name . $parentId)->pipe('md5');

        $id = Cache::get($cacheKey, function () use ($name, $parentId, $cacheKey) {
            $query = $this->modelCategory->where('title', $name);

            if ($parentId) {
                $query = $query->where('parent_id', $parentId);
            }

            $query = $query->select('id')->first();

            if ($query) {
                $id = $query->id;
                Cache::put($cacheKey, $query->id, 3600);
            } else {
                $id = null;
            }

            return $id;
        });

        return $id;
    }

    private function createCategoryByName(string $name, ?int $parentId): ?int
    {
        $category = $this->modelCategory->create([
            'title'     => $name,
            'parent_id' => $parentId
        ]);

        return ($category) ? $category->id : null;
    }
}
