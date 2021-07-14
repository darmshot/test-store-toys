<?php

namespace Tests\Services\Parsers\Builders;

use App\Services\Parsers\Builders\ManufacturerBuild;
use Tests\TestCase;

class ManufacturerBuildTest extends TestCase
{
    /**
     * @var ManufacturerBuild|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = app(ManufacturerBuild::class);
    }

    public function testGetId()
    {
        $id = $this->builder->setFields([
            'title' => 'Производитель'
        ])->getId();

        dump('ID: ' . $id);
        $this->assertTrue(true);
    }

    public function testGetIdInsert()
    {
        $id = $this->builder->setFields([
            'title'       => 'Производитель',
            'description' => 'Описание'
        ])->getIdInsertOrUpdate();

        dump('ID: ' . $id);
        $this->assertTrue($id > 0);
    }
}
