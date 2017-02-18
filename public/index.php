<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__.'/../config/base.php';

use UrlShorter\App;
use UrlShorter\Libs\Database\PdoMysqlDriver;
use UrlShorter\LongUrlController;
use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\LongUrlRepository;

$repository = new LongUrlRepository(PdoMysqlDriver::fromArrayConfig($config['db']));

$app = new App(__DIR__, new LongUrlController($repository));

$app->dispatch(new HttpRequest($_SERVER, $_GET));
