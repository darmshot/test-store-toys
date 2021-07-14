<?php


namespace App\Services\Parsers\Sites\Darvish\Templates;


use App\Services\Parsers\Builders\AttributeBuild;
use App\Services\Parsers\Builders\CategoryBuild;
use App\Services\Parsers\Builders\ManufacturerBuild;
use App\Services\Parsers\Builders\ProductBuild;
use App\Services\Parsers\Contracts\TemplateContract;
use App\Services\Parsers\Sites\Darvish\LoadDarvish;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ProductTemplate implements TemplateContract
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var LoadDarvish
     */
    private $loader;
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var AttributeBuild
     */
    private $buildAttribute;
    /**
     * @var CategoryBuild
     */
    private $buildCategory;
    /**
     * @var ManufacturerBuild
     */
    private $buildManufacturer;
    /**
     * @var ProductBuild
     */
    private $buildProduct;
    private $attempts;

    public function __construct(Client $client, LoadDarvish $loader)
    {
        $this->client = $client;
        $this->loader = $loader;

        $this->buildAttribute    = new AttributeBuild();
        $this->buildCategory     = new CategoryBuild();
        $this->buildManufacturer = new ManufacturerBuild();
        $this->buildProduct      = new ProductBuild();
    }

    public function load(string $url, array $data = []): array
    {
        // setup page
        $isLoadPage = $this->setupCrawler($url);

        if ( ! $isLoadPage) {
            if ($this->attempts > 2) {
                info(__METHOD__ . ' : error load!');

                return [];
            } else {
                $this->attempts ++;
            }

            return $this->load($url, $data);
        }

        // parsing
        $productInfo      = $this->parseProduct();
        $breadcrumbsData  = $this->parseBreadcrumbs();
        $manufacturerInfo = $this->parseManufacturerInfo();
        $attributesData   = $this->parseAttributes();

//        dump($productInfo, $breadcrumbsData, $manufacturerInfo, $attributesData);

        // loading
        if ($productInfo) {
            // get product
//            $productId = $this->buildProduct->setFields([
//                'sku' => $productInfo['sku']
//            ])->getId();


//            if ($productId == null) {

                // get attributes
                $attributes = [];
                foreach ($attributesData as $item) {
                    $attributeId = $this->buildAttribute->setFields([
                        'title' => $item['name']
                    ])->getIdInsertOrUpdate();

                    $attributes[] = [
                        'id'    => $attributeId,
                        'value' => $item['value']
                    ];
                }

                // get categories
                if ($breadcrumbsData) {
                    $mainCategoryId = $this->buildCategory->setFields([
                        'path' => $breadcrumbsData
                    ])->getIdInsertOrUpdate();
                } else {
                    $mainCategoryId = null;
                }

                // get manufacturer
                if ($manufacturerInfo) {
                    $manufacturerId = $this->buildManufacturer->setFields([
                        'title' => $manufacturerInfo['name']
                    ])->getId();

                    if ($manufacturerId == null) {
                        $this->loader->setType(ManufacturerTemplate::class);
                        $loader = $this->loader->load($manufacturerInfo['url']);

                        if (isset($loader['data']['manufacturer_id'])) {
                            $manufacturerId = $loader['data']['manufacturer_id'];
                        }
                    }
                } else {
                    $manufacturerId = null;
                }

                // add product
                $this->buildProduct->setFields([
                    'title'               => $productInfo['title'],
                    'meta_title'          => $productInfo['title'],
                    'sku'                 => $productInfo['sku'],
                    'product_load_images' => $productInfo['images'],
                    'attributes'          => $attributes,
                    'main_category_id'    => $mainCategoryId,
                    'manufacturer_id'     => $manufacturerId
                ])->getIdInsertOrUpdate();
            }
//        }

        // set result

        return [];
    }

    private function setupCrawler($url): bool
    {
        try {
            $request = $this->client->request('get', $url);
            $html    = $request->getBody()->getContents();
        } catch (\Exception $exception) {
            sleep(2);

            return false;
        }

        $this->crawler = new Crawler(null, $url);

        $this->crawler->addHtmlContent($html);

        return true;
    }

    private function parseProduct(): array
    {
        $node = $this->crawler->filter('.product__left .text-item')->eq(1);
        $data = [];

        if ($node->count()) {
            $text        = $node->text();
            $textParts   = explode(':', $text);
            $data['sku'] = trim($textParts[1]);
        }

        $node = $this->crawler->filter('.main__descr .show')->first();
        if ($node->count()) {
            $data['description'] = $node->text();
        }

        $node = $this->crawler->filter('h1')->first();
        if ($node->count()) {
            $data['title'] = $node->text();
        }

        $images = $this->crawler->filter('.gallery__box a')->each(function (Crawler $node) {
            return $node->link()->getUri();
        });

        if ($images) {
            $data['images'] = $images;
        }

        return $data;
    }

    private function parseAttributes(): array
    {
        $nodes = $this->crawler->filter('.discript tbody tr')->each(function (Crawler $node) {
            return [
                'name'  => $node->filter('td')->eq(0)->text(),
                'value' => $node->filter('td')->eq(1)->text()
            ];
        });

        return $nodes;
    }

    private function parseBreadcrumbs(): array
    {
        $nodes = $this->crawler->filter('.breadcrumbs li')->each(function ($node) {
            return $node->text();
        });

        return $nodes;
    }

    private function parseManufacturerInfo(): array
    {
        $node = $this->crawler->filter('.product__left .text-item a.blue')->first();

        if ($node->count()) {
            $result = ['name' => $node->text(), 'url' => $node->link()->getUri()];
        } else {
            $result = [];
        }

        return $result;
    }
}
