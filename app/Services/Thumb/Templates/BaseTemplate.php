<?php


namespace App\Services\Thumb\Templates;


use Illuminate\Support\Facades\Storage;

abstract class BaseTemplate
{
    protected bool $makeWebp = false;
    protected string $prefix = '';
    protected array $sizes = [];
    protected array $srcset = [];
    protected ?string $placeholder = null;
    protected ?string $width = null;
    protected ?string $height = null;

    protected string $path = '';
    protected bool $isSupportWebp = false;
    private string $dirname = '';
    private string $filename = '';
    private string $extension = '';


    abstract protected function make($slug = null): ?string;


    public function isMultiImage(): bool
    {
        return !empty($this->srcset);
    }

    public function setPath(string $path)
    {
        $i = pathinfo($path);

        if ( ! empty($i['dirname']) && ! empty($i['extension']) && ! empty($i['filename'])) {
            $this->dirname   = $i['dirname'];
            $this->filename  = $i['filename'];
            $this->extension = ($this->isSupportWebp && $this->makeWebp ? 'webp' : $i['extension']);
            $this->path      = $path;
        }
    }

    public function setSupportWebp(bool $isSupport)
    {
        $this->isSupportWebp = $isSupport;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getSrc(): ?string
    {
        $storagePath = $this->dirname . '/' . (($this->prefix) ? $this->prefix . '-' : '') . $this->filename . '.' . $this->extension;


        $newPath = $this->storage($storagePath, 'default');

        return $newPath ? $this->makeUrl($newPath) : null;
    }


    /**
     * srcset="elva-fairy-320w.jpg 320w,
     * elva-fairy-480w.jpg 480w,
     * elva-fairy-800w.jpg 800w"
     */
    public function getSrcset(): ?string
    {
        $paths = [];
        foreach ($this->srcset as $key => $slug) {
            $storagePath = $this->dirname . '/' . (($this->prefix) ? $this->prefix . '-' : '') . $this->filename . '-' . $key . '.' . $this->extension;
            $newPath     = $this->storage($storagePath, $slug);

            if ($newPath) {
                $paths[] = $this->makeUrl($newPath) . ' ' . $key;
            }
        }

        if ($paths) {
            $result = implode(",\n", $paths);
        } else {
            $result = null;
        }

        return $result;
    }

    public function getSizes(): ?string
    {
        if ($this->sizes) {
            $result = implode(",\n", $this->sizes);
        } else {
            $result = null;
        }

        return $result;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function getHeight(): ?string
    {
        return $this->height;

    }

    private function storage($storagePath, $makeSlug)
    {
        $hasFile = Storage::disk('cache')->has($storagePath);
        $path    = null;
        $newPath = 'cache/' . $storagePath;

        if ($hasFile) {
            $path = $newPath;
        } else {
            try {
                $make      = $this->make($makeSlug);
                $isSuccess = Storage::disk('cache')->put($storagePath, $make);

                if ($isSuccess) {
                    $path = $newPath;
                }
            } catch (\Exception $exception) {
            }
        }

        return $path;
    }


    private function makeUrl($path)
    {
//        $url = url(explode($this->publicPath, $fullPath)[1]);
        $url = url($path);

        return $url;
    }
}
