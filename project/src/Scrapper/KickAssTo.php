<?php
/**
 * Created by PhpStorm.
 * User: oscargaravito
 * Date: 2014-08-18
 * Time: 11:01 PM
 */

namespace Movies\Scrapper;


class KickAssTo {

    const SEARCH_PATTERN_BY_IMDB = 'http://kickass.to/usearch/category%3Amovies%20imdb%3A%d%20is_safe%3A1/?field=seeders&sorder=desc';
    const SEARCH_PATTERN_BY_TITLE = 'http://kickass.to/usearch/{SEARCH}%20category:movies%20is_safe:1/?field=seeders&sorder=desc';

    /**
     * @var Helper
     */
    private $helper;

    public function __construct(Helper $helper) {
        $this->helper = $helper;
    }

    public function getTorrent($title, $num = 4){

        $url = str_replace('{SEARCH}', urlencode($title), self::SEARCH_PATTERN_BY_TITLE);

        $resultHTML = $this->helper->getHTMLFromUrl($url, true);

        $torrents = $this->getTorrentsFromHTML($resultHTML);

        return array_slice($torrents, 0,$num);

    }

    private function getTorrentsFromHTML($resultHTML) {
        $doc = new \DOMDocument();
        @$doc->loadHTML($resultHTML);
        $xpath = new \DOMXpath($doc);

        $elements = $xpath->query("//table[@class='data']//tr[@id]");
        $torrents = array();
        for ($i=0 ;$i<$elements->length; ++$i) {
            $torrents[] = $this->getTorrentItem($xpath, $elements->item($i));
        }

        return $torrents;
    }

    private function getTorrentItem(\DOMXPath $xpath, \DOMElement $element){

        $item = new \Movies\Entities\Torrent();

        $elementList = $xpath->query(".//a[@class='cellMainLink']", $element);
        $item->title = trim(strip_tags($elementList->item(0)->nodeValue));

        $elementList = $xpath->query(".//td//div[@class='iaconbox floatright']//a[@class='idownload icon16']", $element);
        $item->url = $elementList->item(0)->attributes->getNamedItem('href')->nodeValue;

        $elementList = $xpath->query(".//td", $element);
        $item->movieSize = strip_tags($elementList->item(1)->nodeValue);
        $item->numberOfFiles = strip_tags($elementList->item(2)->nodeValue);
        $item->age = strip_tags($elementList->item(3)->nodeValue);
        $item->seed = strip_tags($elementList->item(4)->nodeValue);
        $item->leech = strip_tags($elementList->item(5)->nodeValue);

        return $item;
    }

} 