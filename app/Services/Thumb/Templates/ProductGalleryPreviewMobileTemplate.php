<?php


namespace App\Services\Thumb\Templates;


use App\Services\Thumb\Contracts\TemplateContract;
use Image;

class ProductGalleryPreviewMobileTemplate extends BaseTemplate implements TemplateContract
{
    protected bool $makeWebp = true;
    protected string $prefix = 'pgpm';
    protected array $sizes = [
//        '(max-width: 575px) 565px',
//        '(max-width: 768px) 260px',
//        '(max-width: 991px) 350px',
//        '320px'
    ];
    /**
     * @var array|string[]
     *
     * size => $slug (for $this->make($slug))
     */
    protected array $srcset = [
//        '360w'  => '360',
//        '720w'  => '720',
//        '1080w' => '1080',
//        '1920w' => '1920',
    ];

    protected ?string $height = '250';
    protected ?string $placeholder = 'storage/placeholder.jpg';

    protected function make($slug = 'default'): ?string
    {

        $image = Image::make(public_path($this->path))
                      ->heighten(250, function ($constraint) {
                          $constraint->upsize();
                      });

        if ($this->isSupportWebp) {
            $image->encode('webp');
        } else {
            $image->encode();
        }

        return $image->getEncoded();
    }
}
