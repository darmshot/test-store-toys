<?php


namespace App\Services\Thumb\Templates;


use App\Services\Thumb\Contracts\TemplateContract;
use Image;

class ProductGalleryPreviewDesktopTemplate extends BaseTemplate implements TemplateContract
{
    protected bool $makeWebp = true;
    protected string $prefix = 'pgpd';

    protected array $sizes = [
        '(max-width: 991px) 175px',
        '(max-width: 1199px) 235px',
        '(max-width: 1399px) 280px',
        '320px'
    ];
    /**
     * @var array|string[]
     *
     * size => $slug (for $this->make($slug))
     */
    protected array $srcset = [
        '360w'  => '360',
        '720w'  => '720',
//        '1080w' => '1080',
//        '1920w' => '1920',
        '175w'  => '175',
        '235w'  => '235',
        '280w'  => '280',
        '320w'  => 'default'
    ];

    protected ?string $width = '320';
    protected ?string $height = '320';

    protected ?string $placeholder = 'storage/placeholder.jpg';

    protected function make($slug = 'default'): ?string
    {
        if ($slug == 'default') {
            $image = Image::make(public_path($this->path))
                          ->widen($this->width, function ($constraint) {
                              $constraint->upsize();
                          });

        } else {
            $image = Image::make(public_path($this->path))
                          ->widen($slug, function ($constraint) {
                              $constraint->upsize();
                          });
        }


        if ($this->isSupportWebp) {
            $image->encode('webp');
        } else {
            $image->encode();
        }

        return $image->getEncoded();
    }
}
