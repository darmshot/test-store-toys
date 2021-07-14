<?php


namespace App\Services\Thumb\Templates;


use App\Services\Thumb\Contracts\TemplateContract;
use Image;

class ProductGalleryFullScreenTemplate extends BaseTemplate implements TemplateContract
{
    protected bool $makeWebp = true;
    protected string $prefix = 'pgfs';

    protected ?string $placeholder = 'storage/placeholder.jpg';

    protected function make($slug = 'default'): ?string
    {
        $image = Image::make(public_path($this->path));

        if ($this->isSupportWebp) {
            $image->encode('webp');
        } else {
            $image->encode();
        }

        return $image->getEncoded();
    }
}
