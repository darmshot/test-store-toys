<?php


namespace App\Services\Thumb\Templates;


use App\Services\Thumb\Contracts\TemplateContract;
use Image;

class ProductThumbTemplate extends BaseTemplate implements TemplateContract
{
    protected bool $makeWebp = true;
    protected string $prefix = 'pt';
    protected array $sizes = [
        '(max-width: 575px) 565px',
        '(max-width: 768px) 260px',
        '(max-width: 991px) 350px',
        '320px'
    ];
    /**
     * @var array|string[]
     *
     * size => $slug (for $this->make($slug))
     */
    protected array $srcset = [
        '360w' => '360',
        '720w' => '720',
        '1080w' => '1080',
//        '1920w' => '1920',
        '565w' => '565',
        '260w' => '260',
        '350w' => '350',
        '320w' => 'default'
    ];

    protected ?string $width = '320';
    protected ?string $height = '245';

    protected ?string $placeholder = 'storage/placeholder.jpg';

    protected function make($slug = 'default'): ?string
    {
        if ($slug == 'default') {

            $image = Image::make(public_path($this->path))
                          ->fit($this->width, $this->height);
        } else {
            $image = Image::make(public_path($this->path))
                          ->fit($slug, $this->height);
        }

//              ->insert($watermark_new, 'center');

        if ($this->isSupportWebp) {
            $image->encode('webp');
        } else {
            $image->encode();
        }

        return $image->getEncoded();
    }
}
