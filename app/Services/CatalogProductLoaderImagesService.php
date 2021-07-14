<?php


namespace App\Services;


use App\Models\Admin\CatalogProduct;
use App\Models\Admin\CatalogProductLoadImage;

class CatalogProductLoaderImagesService
{
    /**
     * @var CatalogProductLoadImage| \Eloquent
     */
    private $loadImagesModel;
    /**
     * @var CatalogProduct | \Eloquent
     */
    private $productModel;
    /**
     * @var string
     */
    private $publicPath;

    public function __construct(CatalogProductLoadImage $loadImage, CatalogProduct $catalogProduct)
    {
        $this->loadImagesModel = $loadImage;
        $this->productModel    = $catalogProduct;
        $this->publicPath      = public_path('/');

    }


    public function load($part = 1): int
    {
        $imagesData = $this->loadImagesModel->offset(20 * ($part - 1))->limit(20)->get();

        foreach ($imagesData as $row) {
            $uploadedImages     = [];
            $dir                = 'products/' . $row->product_id . '/';
            $isHasProductImages = \Storage::disk('uploads')->exists($dir);

            if ( ! $isHasProductImages) {
                foreach ($row['images'] as $url) {
                    $path = $this->uploadFile($url, $dir);

                    if ($path) {
                        $uploadedImages[] = $path;
                    } else {
                        dump('error load - product_id:' . $row->product_id . ', url: ' . $url);
                    }
                }
            }

            if ($uploadedImages) {
                $this->productModel->find($row->product_id)->update([
                    'images' => $uploadedImages
                ]);
            }

            $this->loadImagesModel::find($row->id)->delete();
        }

        if ($imagesData->isEmpty()) {
            return 0;
        } else {
            return ++ $part;
        }
    }


    public function uploadFile($url, $dir, $attempts = 0)
    {
        $info = pathinfo($url);

        if (empty($info['extension'])) {
            return null;
        }

        try {
            $contents = file_get_contents($url);
        } catch (\Exception $exception) {
            if ($attempts < 2) {
                ++ $attempts;
                sleep(1);

                return $this->uploadFile($url, $dir, $attempts);
            } else {
                return null;
            }
        }

        $new_file_name = md5($info['filename'] . random_int(1, 9999) . time()) . '.' . $info['extension'];
        $path          = $dir . $new_file_name;
        \Storage::disk('uploads')->put($path, $contents);
        $fullPath = \Storage::disk('uploads')->path($path);

        $savePath = explode($this->publicPath, $fullPath)[1];


        return $savePath;
    }
}
