<?php


namespace App\Services\Parsers\Sites\Darvish\Templates;


use App\Services\Parsers\Builders\ManufacturerBuild;
use App\Services\Parsers\Contracts\TemplateContract;
use App\Services\Parsers\Sites\Darvish\LoadDarvish;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ManufacturerTemplate implements TemplateContract
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
     * @var ManufacturerBuild
     */
    private $buildManufacturer;
    private $attempts;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->buildManufacturer = new ManufacturerBuild();

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
        $title       = $this->parseTitle();
        $description = $this->parseDescription();

        // loading

        $id = $this->buildManufacturer->setFields([
            'title' => $title
        ])->getId();

        if ($id) {
            $manufacturer_id = $id;
        } else {
            $manufacturer_id = $this->buildManufacturer->setFields([
                'title'       => $title,
                'description' => $description
            ])->getIdInsertOrUpdate();
        }

        // set result

        return ['data' => ['manufacturer_id' => $manufacturer_id]];
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

    private function parseTitle()
    {
        $node = $this->crawler->filter('h1')->first();

        return $node->count() ? $node->text() : null;
    }

    private function parseDescription()
    {
        $node = $this->crawler->filter('.short__box .short__box')->first();

        return $node->count() ? $node->outerHtml() : null;
    }

}
