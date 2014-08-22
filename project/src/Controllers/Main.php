<?php
/**
 * Created by PhpStorm.
 * User: oscargaravito
 * Date: 2014-08-17
 * Time: 1:29 AM
 */

namespace Movies\Controllers;


class Main {

    public function lastDVDMovies(){

        $layout = new \TemplateEngine\Layout('layoutGlobal', RESOURCES_FOLDER . '/views/');

        $items = $this->getDVDs(14*4);
        //$items = $this->getByTitle('Coherence');

        $data = array('dvds'=>$items);

        $layout->addZone('main', 'index', $data);

        echo $layout->render();

    }

    private function getDVDs($numItems = 15){
        $scrapperHelper = new \Movies\Scrapper\Helper(CACHE_FOLDER, API_KEY_TMDB);

        $scrapper = new \Movies\Scrapper\RottenTomatoes($scrapperHelper);

        return $scrapper->getLastDVDs($numItems);
    }

    private function getByTitle($title){
        $scrapperHelper = new \Movies\Scrapper\Helper(CACHE_FOLDER, API_KEY_TMDB);

        $scrapper = new \Movies\Scrapper\RottenTomatoes($scrapperHelper);

        return $scrapper->getByTitle($title);
    }


} 