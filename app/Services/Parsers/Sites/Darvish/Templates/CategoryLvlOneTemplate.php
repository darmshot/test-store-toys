<?php


namespace App\Services\Parsers\Sites\Darvish\Templates;

use App\Services\Parsers\Contracts\TemplateContract;
use App\Services\Parsers\Sites\Darvish\LoadDarvish;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class CategoryLvlOneTemplate implements TemplateContract
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
    private $attempts;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->loader = new LoadDarvish();
    }

    public function load(string $url, array $data = []): array
    {
        // setup page
        $isLoadPage = $this->setupCrawler($url);

        if ( ! $isLoadPage) {
            if ($this->attempts > 2) {
                return [];
            } else {
                $this->attempts ++;
            }

            return $this->load($url, $data);
        }

        // parsing
        if (isset($data['previous'])) {
            $categoryInfo = $this->parseNextCategory($data['previous']);
        } else {
            $categoryInfo = $this->parseFirstCategory();
        }

        // loading
        if ($categoryInfo) {
            $this->loader->setType(CategoryLvlTwoTemplate::class);

            $loader = $this->loader->load($categoryInfo['url'], [
                'previous'         => $categoryInfo['name'],
                'from_lvl_one_url' => $this->crawler->getUri()
            ]);
        } else {
            $loader = [];
        }

        // set result for next tick
        if ($loader) {
            $loadNext = ['url' => $loader['url'], 'type' => $loader['type'], 'data' => $loader['data']];
        } else {
            $loadNext = [];
        }

        return $loadNext;
    }

    private function parseNextCategory($beforeName)
    {
        $nodes          = $this->crawler->filter('.category__all > a')->each(function ($node) {
            $name = $node->filter('p')->first()->text();
            $url  = $node->link()->getUri();

            return ['name' => $name, 'url' => $url];
        });
        $currentItemKey = null;


        foreach ($nodes as $key => $item) {
            if ($item['name'] == $beforeName) {
                $currentItemKey = $key;
            }
        }

        $nextItemKey = $currentItemKey !== null ? ++ $currentItemKey : null;

        if (isset($nodes[$nextItemKey])) {
            $result = $nodes[$nextItemKey];
        } else {
            $result = [];
        }

        return $result;
    }

    private function parseFirstCategory()
    {
        // first exclude
        $node = $this->crawler->filter('.category__all > a')->eq(0);

        if ($node->count()) {
            $result = ['url' => $node->link()->getUri(), 'name' => $node->filter('p')->first()->text()];
        } else {
            $result = [];
        }

        return $result;
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
}
