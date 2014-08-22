<?php


namespace Movies;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class BootLoader {

    private $container;

    public function boot(){
        date_default_timezone_set('America/Montreal');
        $this->container = array();
        $this->bootMatcher($this->container);
    }

    public function getContainer(){
        return $this->container;
    }

    private function bootMatcher(&$container)
    {

        $locator = new FileLocator(array(CONFIG_FOLDER));
        $loader = new YamlFileLoader($locator);
        $collection = $loader->load('routes.yml');
        $collection->addPrefix('/testTomatoes/project/htdocs/');

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
        $matcher = new UrlMatcher($collection, $context);

        $container['matcher'] = $matcher;

    }

} 