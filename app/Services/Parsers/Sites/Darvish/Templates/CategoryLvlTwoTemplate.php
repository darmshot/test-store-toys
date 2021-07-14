<?php


namespace App\Services\Parsers\Sites\Darvish\Templates;


use App\Services\Parsers\Contracts\TemplateContract;
use App\Services\Parsers\Sites\Darvish\LoadDarvish;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CategoryLvlTwoTemplate implements TemplateContract
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var LoadDarvish
     */
    private $loader;
    private $attempts = 0;

    public function __construct(Client $client, LoadDarvish $loader)
    {
        $this->client = $client;
        $this->loader = $loader;

    }

    public function load(string $url, array $data = []): array
    {
        // setup page
        $isLoadPage = $this->setupCrawler($url);

        if ( ! $isLoadPage) {
            if ($this->attempts > 2) {
                info(__METHOD__.' : error load!');
                return [];
            } else {
                $this->attempts ++;
            }

            return $this->load($url, $data);
        }


        // parsing
        $productUrls = $this->parseProductsUrls();
        $nextUrl     = $this->parseNextPageUrl();

        // loading
        $this->loader->setType(ProductTemplate::class);
        foreach ($productUrls as $url) {
            $this->loader->load($url);
        }

        // set result fro next tick
        if ($nextUrl) {
            $loadNext = ['url' => $nextUrl, 'type' => self::class, 'data' => $data];
        } else {
            $loadNext = ['url' => $data['from_lvl_one_url'], 'type' => CategoryLvlOneTemplate::class, 'data' => $data];
        }

        return $loadNext;
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

    private function parseProductsUrls(): array
    {
        $crawler = $this->crawler->filter('.catalog__area-box .items .card__item > a.js-ec-click');
        $nodes   = $crawler->each(function (Crawler $node) {
            return $node->link()->getUri();
        });

        return $nodes;
    }

    private function parseNextPageUrl(): string
    {
        $node = $this->crawler->filter('.pagination .btn__right')->first();

        if ($node->count()) {
            $url = $node->link()->getUri();
        } else {
            $url = '';
        }

        return $url;
    }

}
