<?php

date_default_timezone_set('America/Montreal');

require_once(__DIR__ . '/../../project/conf/config.php');

require VENDOR_FOLDER . '/autoload.php';

$scrapperHelper = new \Movies\Scrapper\Helper(CACHE_FOLDER, API_KEY_TMDB);

$scrapper = new \Movies\Scrapper\RottenTomatoes($scrapperHelper);
$scrapperTorrent = new \Movies\Scrapper\KickAssTo($scrapperHelper);

$items = $scrapper->getByTitle('zero theorem');

foreach ($items as $i=>$item) {
    echo $i. ': ' .$item->title;
    //echo ': ' . $item->url;
    //$t = $scrapperTorrent->getTorrent($item->title, 3);
var_dump($item);
    echo PHP_EOL;
}

