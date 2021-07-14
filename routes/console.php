<?php

use App\Services\CatalogProductLoaderImagesService;
use App\Services\Parsers\Sites\Darvish\LoadDarvish;
use App\Services\Parsers\Sites\Darvish\Templates\CategoryLvlOneTemplate;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('parser', function () {
    $this->comment('parser start!');

    $parser = new LoadDarvish();

    $result = [
//        'url'  => 'https://darvish.by/katalog/igrushki_i__tvorchestvo/',
        'url'  => 'https://darvish.by/katalog/tovary-dlya-doma-i-khoztovary/',
        'type' => CategoryLvlOneTemplate::class,
        'data' => [
            'previous'         => 'Новогодняя продукция',
//            'from_lvl_one_url' => 'https://darvish.by/katalog/igrushki_i__tvorchestvo/'
        ]
    ];
    while ($result) {
        $parser->setType($result['type']);
        $result = $parser->load($result['url'], $result['data']);
        dump($result);
    }

    $this->comment('parsing end!');
})->purpose('Parsing');


Artisan::command('product-load-images', function () {
    $this->comment('start!');
    $load = app(CatalogProductLoaderImagesService::class);

    $nextPart = 1;
    while ($nextPart) {
        dump($nextPart);
        $nextPart = $load->load($nextPart);
    }

    $this->comment('end!');


})->purpose('Display an inspiring quote');
