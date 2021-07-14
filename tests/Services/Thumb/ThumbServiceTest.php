<?php

namespace Tests\Services\Thumb;

use App\Services\Thumb\Templates\ProductThumbTemplate;
use App\Services\Thumb\ThumbService;
use Tests\TestCase;

class ThumbServiceTest extends TestCase
{
    /**
     * @var ThumbService|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $thumb;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->thumb = app(ThumbService::class);
    }

    public function testGetFromArray()
    {
        $result = $this->thumb->template(ProductThumbTemplate::class)->get([
            'uploads/products/102/257a93b4e956f4b43c8c58ffa95999d8.jpg',
        ]);

        dump($result);

        $this->assertNotEmpty($result);
    }


    public function testGetFromWrongArray()
    {

        $result = $this->thumb->template(ProductThumbTemplate::class)->get([
            '!!!uploads/products/102/257a93b4e956f4b43c8c58ffa95999d8.jpg',
            null
        ]);

        dump($result);

        $this->assertTrue(true);
    }

    public function testGetFromString()
    {
        $result = $this->thumb->template(ProductThumbTemplate::class)->get('uploads/products/102/257a93b4e956f4b43c8c58ffa95999d8.jpg');

        $this->assertNotEmpty($result);

        dump($result);
    }


    public function testGetFromWrongString()
    {
        $result = $this->thumb->template(ProductThumbTemplate::class)->get('!!!uploads/products/102/257a93b4e956f4b43c8c58ffa95999d8.jpg');

        dump($result);

        $result = $this->thumb->template(ProductThumbTemplate::class)->get(null);

        dump($result);

        $this->assertTrue(true);
    }
}
