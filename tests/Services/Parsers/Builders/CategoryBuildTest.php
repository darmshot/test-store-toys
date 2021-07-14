<?php

namespace Tests\Services\Parsers\Builders;

use App\Services\Parsers\Builders\CategoryBuild;
use Tests\TestCase;

class CategoryBuildTest extends TestCase
{
    /**
     * @var CategoryBuild|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $bulder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bulder = app(CategoryBuild::class);
    }

    public function testGetIdInsert()
    {
        $id = $this->bulder->setFields([
            'path' => ['главная категория', 'дочерняя lvl 2', 'дочерняя lvl 3']
        ])->getIdInsertOrUpdate();

        dump('ID: ' . $id);

        $this->assertTrue($id > 0);
    }
}
