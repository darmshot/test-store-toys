<?php


namespace App\Services\Parsers\Builders;


use App\Models\Admin\CatalogAttribute;
use App\Services\Parsers\Contracts\BuilderContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AttributeBuild implements BuilderContract
{
    /**
     * @var array
     */
    private $fields;
    /**
     * @var CatalogAttribute|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $modelAttribute;

    public function __construct()
    {
        $this->modelAttribute = app(CatalogAttribute::class);

    }

    public function getId(): ?int
    {
        if (empty($this->fields['title'])) {
            return null;
        }

        $title = $this->fields['title'];

        $id = null;

        $query = $this->modelAttribute->where('title', $title)->first();

        if ($query) {
            $id = $query->id;
        }

        return $id;
    }

    public function getIdInsertOrUpdate(): ?int
    {
        $id = null;

        if (empty($this->fields['title'])) {
            return null;
        }

        $title = Str::limit($this->fields['title'], 50);

        $cacheKey = 'attribute_build_id.' . Str::of($title)->pipe('md5');

        $id = Cache::get($cacheKey, function () use ($title,$cacheKey) {
            $query = $this->modelAttribute->where('title', $title)->first();

            if ($query) {
                Cache::put($cacheKey, $query->id, 3600);
                return $query->id;
            } else {
                return null;
            }
        });

        if ($id == null) {
            $attribute = $this->modelAttribute::create([
                'title' => $title,
            ]);
            $id        = $attribute->id;

            Cache::put($cacheKey, $id, 3600);
        }

        return $id;
    }

    public function setFields(array $fields): BuilderContract
    {
        $this->fields = $fields;

        return $this;
    }
}
