<?php

define('PROJECT_ROOT_FOLDER', realpath(__DIR__ . '/..'));
define('CONFIG_FOLDER', PROJECT_ROOT_FOLDER . '/conf/');
define('VENDOR_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/../vendor/'));
define('CACHE_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/../cache/'));
define('RESOURCES_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/resources/'));

define('PROJECT_DOMAIN', 'http://{YOUR_DOMAIN}');
define('ROUTE_PREFIX', '/{PREFIX_FOR_URL}');

define('PROJECT_URL', PROJECT_DOMAIN . ROUTE_PREFIX);

define('API_KEY_TMDB', 'KEY_FROM_TMDB_HERE');
