<?php


namespace App\Services\Thumb;


use App\Services\Thumb\Contracts\TemplateContract;
use Illuminate\Support\Facades\Cache;

class ThumbService
{
    /**
     * @var  TemplateContract
     */
    private mixed $templateApp;
    private bool $isMultiImage = false;
    private $placeholder = null;
    private string $template;

    public function __construct()
    {

    }

    public function template(string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     *
     * @param $images array | string | mixed
     *
     * @return array|string
     */
    public function get(?array $images): ?array
    {
        if (isset($_SERVER['HTTP_WEBP']) && $_SERVER['HTTP_WEBP'] == 'true') {
            $isSupportWebp = 1;
        } else if (str_contains(($_SERVER['HTTP_ACCEPT'] ?? ''), 'image/webp')) {
            // webp is supported!
            $isSupportWebp = 1;
        } else {
            $isSupportWebp = 0;
        }


        if(env('APP_DEBUG')){
            return $this->build($isSupportWebp, $images);
        }


        $imagesToStr = json_encode($images);
        $cacheKey = md5($isSupportWebp . $this->template . $imagesToStr);


        $result = Cache::get($cacheKey, function () use ($isSupportWebp, $images, $cacheKey) {
            $result =  $this->build($isSupportWebp, $images);

            if ($result) {
                Cache::put($cacheKey, $result, 3600);
            }

            return $result;
        });


        return $result;
    }

    private function build($isSupportWebp,  ?array $images): array
    {
        $this->templateApp = app($this->template);
        $this->templateApp->setSupportWebp($isSupportWebp);
        $this->isMultiImage = $this->templateApp->isMultiImage();
        $this->placeholder  = $this->templateApp->getPlaceholder();

        $result = [];

        if ($images) {
            foreach ($images as $path) {
                $image = $this->createImage($path);

                if ($image) {
                    $result[] = $image;
                }
            }
        }
        if (empty($result) && $this->placeholder) {
            $image = $this->createImage($this->placeholder);

            if ($image) {
                $result[] = $image;
            }
        }

        return $result;
    }

    private function createImage($path)
    {
        $image = [];

        if (empty($path)) {
            return $image;
        }

        $this->templateApp->setPath($path);
        $src = $this->templateApp->getSrc();

        if ($src) {
            if ($this->isMultiImage) {
                $image = [
                    'src'    => $src,
                    'srcset' => $this->templateApp->getSrcset(),
                    'sizes'  => $this->templateApp->getSizes(),
                    'width'  => $this->templateApp->getWidth(),
                    'height' => $this->templateApp->getHeight()
                ];
            } else {
                $image = [
                    'src'    => $src,
                    'width'  => $this->templateApp->getWidth(),
                    'height' => $this->templateApp->getHeight()
                ];
            }
        }

        return $image;
    }
}
