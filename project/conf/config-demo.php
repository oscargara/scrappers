<?php

date_default_timezone_set('America/Montreal');

define('PROJECT_ROOT_FOLDER', realpath(__DIR__ . '/..'));
define('CONFIG_FOLDER', PROJECT_ROOT_FOLDER . '/conf/');
define('VENDOR_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/../vendor/'));
define('CACHE_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/../cache/'));
define('RESOURCES_FOLDER', realpath(PROJECT_ROOT_FOLDER . '/resources/'));

define('PROJECT_URL', 'http://localhost/testTomatoes/project/htdocs/');

define('API_KEY_TMDB', '04483fd03aa8ff9e62ab3d9eb5fb5929');

define('ROUTE_PREFIX', '/testTomatoes/project/htdocs/');
