<?php


namespace App\Services\Parsers\Builders;


use App\Models\Admin\CatalogManufacturer;
use App\Services\Parsers\Contracts\BuilderContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ManufacturerBuild implements BuilderContract
{

    /**
     * @var array
     */
    private $fields;
    /**
     * @var CatalogManufacturer|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $modelManufacturer;

    public function __construct()
    {
        $this->modelManufacturer = app(CatalogManufacturer::class);
    }

    public function getId(): ?int
    {
        if (empty($this->fields['title'])) {
            return null;
        }

        $title = Str::limit($this->fields['title'], 50);

        $id = null;

        $query = $this->modelManufacturer->where('title', $title)->first();

        if ($query) {
            $id = $query->id;
        }

        return $id;
    }

    public function getIdInsertOrUpdate(): ?int
    {

        if (empty($this->fields['title'])) {
            return null;
        }

        $title = Str::limit($this->fields['title'], 50);

        $cacheKey = 'attribute_build_id.' . Str::of($title)->pipe('md5');

        $id = Cache::get($cacheKey, function () use ($title, $cacheKey) {
            $query = $this->modelManufacturer->where('title', $title)->first();

            if ($query) {
                Cache::put($cacheKey, $query->id, 3600);

                return $query->id;
            } else {
                return null;
            }
        });

        if ($id == null) {
            $attribute = $this->modelManufacturer::create([
                'title'       => $title,
                'description' => $this->fields['description'] ?? null
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
