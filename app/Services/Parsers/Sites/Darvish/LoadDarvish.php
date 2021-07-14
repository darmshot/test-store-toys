<?php


namespace App\Services\Parsers\Sites\Darvish;


use App\Services\Parsers\Contracts\TemplateContract;

class LoadDarvish
{
    /**
     * @var TemplateContract
     */
    private $type = null;

    public function __construct()
    {
//     https://darvish.by/katalog/igrushki_i__tvorchestvo/aktivnye_igry/
    }

    public function setType(string $type)
    {
        $this->type = app($type);
    }


    public function load(string $url, array $data = []): array
    {
        $result = $this->type ? $this->type->load($url, $data) : [];

        return $result;
    }
}
