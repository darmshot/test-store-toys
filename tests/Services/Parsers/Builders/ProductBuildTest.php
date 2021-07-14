<?php

namespace Tests\Services\Parsers\Builders;

use App\Services\Parsers\Builders\ProductBuild;
use Tests\TestCase;

class ProductBuildTest extends TestCase
{
    /**
     * @var ProductBuild|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = app(ProductBuild::class);
    }

    public function testGetId()
    {
        $id = $this->builder->setFields([
            'sku' => 'Undefined product'
        ])->getId();

        $this->assertTrue($id === null);


        $id = $this->builder->setFields([
            'sku' => 'DV-T-2459'
        ])->getId();

        $this->assertTrue( $id > 0);

        dump('ID: '. $id);
    }

    public function testGetIdInsert()
    {


        $id = $this->builder->setFields([
            'title'            => 'Новый товар',
            'description'      => 'Описание товара',
            'manufacturer_id'  => 3,
            'sku'              => '12345',
            'images'           => [
                'https://darvish.by/upload/iblock/c95/034388_1.jpg',
                'https://darvish.by/upload/iblock/3f3/034388_2.jpg'
            ],
            'main_category_id' => 9
        ])->getIdInsertOrUpdate();

        $this->assertIsNumeric($id);
    }
}
