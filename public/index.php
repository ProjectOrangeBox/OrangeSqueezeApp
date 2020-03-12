<?php

use \projectorangebox\app\App;

define('__ROOT__', realpath(__DIR__ . '/../'));

require __ROOT__ . '/startup.php';

$config = parse_ini_file(__ROOT__ . '/.env', true, INI_SCANNER_TYPED);

(new App($config))->dispatch();
