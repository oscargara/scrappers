<?php


namespace Movies\Scrapper;


class Helper {


    const IMAGE_MOVIES = 'https://image.tmdb.org/t/p/w396/';
    /**
     * @var string
     */
    private $cacheFolder;

    private $apiKey;

    public function __construct($cacheFolder, $apiKey){
        $this->cacheFolder = $cacheFolder;
        $this->apiKey =$apiKey;

        if (!is_dir($this->cacheFolder . '/php-tmdb-api')) {
            mkdir($this->cacheFolder . '/php-tmdb-api');
        }
        if (!is_dir($this->cacheFolder . '/html')) {
            mkdir($this->cacheFolder . '/html');
        }
    }

    function getHTMLFromUrl($url, $useCache = true) {

        $cacheFileName = $this->getFilenameForHTMLCache($url);

        $resultHTML = '';

        if ($useCache && file_exists($cacheFileName)) {
            $resultHTML = file_get_contents($cacheFileName);
        }

        if ($resultHTML != ''){
            return $resultHTML;
        }

        // create a new cURL resource
        $ch = curl_init();

        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        $resultHTML = curl_exec($ch);

        if(!$resultHTML || $resultHTML == '') {
            throw new \Exception('ERROR with URL: ' . $url. ' : ' . curl_error($ch));
        }

        curl_close($ch);

        file_put_contents($cacheFileName, $resultHTML);

        return $resultHTML;
    }

    public function removeFromUrlCache($url){
        $cacheFileName = $this->getFilenameForHTMLCache($url);
        @unlink($cacheFileName);
    }

    private function getFilenameForHTMLCache($url){
        return $this->cacheFolder . '/html/'. md5($url) . '.html';
    }

    public function hydrateItem(\Movies\Entities\MovieMeta &$item){

        $token  = new \Tmdb\ApiToken($this->apiKey);
        $client = new \Tmdb\Client($token);
        $client->setCaching(true, $this->cacheFolder . '/php-tmdb-api');

        $result = $client->getSearchApi()->searchMovies($item->title);

        if ($result['total_results'] >0) {
            $item->imageUrl  = self::IMAGE_MOVIES . $result['results'][0]['poster_path'];
            $item->id  = $result['results'][0]['id'];
        }

        $scrapper = new \Movies\Scrapper\KickAssTo($this);

        $item->torrents = $scrapper->getTorrent($item->title);

    }

} 