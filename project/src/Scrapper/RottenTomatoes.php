<?php
/**
 * Created by PhpStorm.
 * User: oscargaravito
 * Date: 2014-08-16
 * Time: 11:31 PM
 */

namespace Movies\Scrapper;


class RottenTomatoes {

    const TARGET_DOMAIN = 'http://www.rottentomatoes.com/';

    const MAIN_PAGE_URL = '/dvd/new-releases/?page=%d&mode=detailed&sortby=release_date&order=desc';

    const SEARCH_URL = '/search/json/?q=%s';

    /**
     * @var Helper
     */
    private $helper;

    public function __construct(Helper $helper) {
        $this->helper = $helper;
    }

    public function getByTitle($title) {
        $urlPattern = self::TARGET_DOMAIN . self::SEARCH_URL;

        $resultHTML = $this->helper->getHTMLFromUrl(sprintf($urlPattern, urlencode($title)), false);

        return $this->getItemsFromSearch($resultHTML);
    }

    private function getItemsFromSearch($resultHTML) {
        $doc = new \DOMDocument();
        @$doc->loadHTML($resultHTML);
        $xpath = new \DOMXpath($doc);

        $elements = $xpath->query("//li[@sub='item']");
        $items = array();
        for ($i=0 ;$i<$elements->length; ++$i) {

            $element = $elements->item($i);
            $item = new \Movies\Entities\MovieMeta();

            $titleElement = $xpath->query(".//div[@class='title nowrap']", $element);
            $item->title = trim($titleElement->item(0)->nodeValue);
            $item->title = trim($this->removeYear($item->title));

            $item->url = self::TARGET_DOMAIN . $element->attributes->getNamedItem('href')->nodeValue;

            $this->hydrateItem($item);
            $items[] = $item;
        }

        return $items;
    }

    public function getLastDVDs($numItems = 15){
        $totalPages = ceil(($numItems+1)/15.0);

        $urlPattern = self::TARGET_DOMAIN . self::MAIN_PAGE_URL;

        $items = array();
        for ($page=1; $page<$totalPages+1; ++$page){
            $resultHTML = $this->helper->getHTMLFromUrl(sprintf($urlPattern, $page), false);
            $items = array_merge($items, $this->getItemsFromLastDVD($resultHTML));
        }

        return array_slice($items,0,$numItems);
    }

    private function getItemsFromLastDVD($resultHTML) {
        $doc = new \DOMDocument();
        @$doc->loadHTML($resultHTML);
        $xpath = new \DOMXpath($doc);

        $elements = $xpath->query("//div[@class='media_block movie_item bottom_divider']");
        $items = array();
        for ($i=0 ;$i<$elements->length; ++$i) {
            $items[] = $this->getItem($xpath, $elements->item($i));
        }
        return $items;
    }


    private function getItem(\DOMXpath $xpath, \DOMElement $element){

        $item = new \Movies\Entities\MovieMeta();

        $elementList = $xpath->query("div[@class='media_block_content']//h2//a", $element);

        $item->title = trim($elementList->item(0)->nodeValue);
        $item->url = self::TARGET_DOMAIN . $elementList->item(0)->attributes->getNamedItem('href')->nodeValue;

        $this->hydrateItem($item);

        return $item;

    }


    private function hydrateItem(\Movies\Entities\MovieMeta &$item){

        $resultHTML = $this->helper->getHTMLFromUrl($item->url);

        $doc = new \DOMDocument();
        @$doc->loadHTML($resultHTML);
        $xpath = new\ DOMXpath($doc);

        $elementList = $xpath->query("//span[@id='all-critics-meter']");
        if ($elementList->length>0) {
            $value = intval(trim($elementList->item(0)->nodeValue));
            if (!$value) {
                //$this->helper->removeFromUrlCache($item->url);
                //throw new \Exception('Impossible to found the criticMeter for : '. $item->url . ' ' . md5($item->url));
            }
            $item->criticMeter = $value;
        }else{
            throw new \Exception('Impossible to found the criticMeter for : '.$item->url);
        }


        //$elementList = $xpath->query("//span[@class='meter * numeric ']");
        $elementList = $xpath->query("//a[@class='fan_side']//span[contains(@class, 'meter') and contains(@class ,'numeric')]");
        if ($elementList->length>0) {
            $value = intval(trim($elementList->item(0)->nodeValue));
            if (!$value) {
                //$this->helper->removeFromUrlCache($item->url);
                //throw new \Exception('Impossible to found the criticMeter for : '. $item->url . ' ' . md5($item->url));
            }
            $item->audienceMeter = $value;
        }else{
            throw new \Exception('Impossible to found the audienceMeter for : '.$item->url);
        }

        $this->helper->hydrateItem($item);

    }


    private function removeYear($title) {

        $pattern = '/(\w+) (\(\d\d\d\d\))/i';
        $replacement = '${1}';

        return preg_replace($pattern, $replacement, $title);
    }

} 