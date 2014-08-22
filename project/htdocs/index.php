<?php

require_once( __DIR__.'/../conf/config.php');
require VENDOR_FOLDER . '/autoload.php';

$bootLoader = new \Movies\BootLoader();

$bootLoader->boot();

$container = $bootLoader->getContainer();

$parameters = $container['matcher']->match($_SERVER['REQUEST_URI']);


list($controllerClass, $action) =  explode('::', $parameters['_controller']);

$controller = new $controllerClass();
$controller->$action();
