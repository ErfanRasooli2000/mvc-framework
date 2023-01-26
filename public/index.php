<?php

require './../vendor/autoload.php';
use App\core\Application;

ini_set('display_errors', 1);

$app = new Application(dirname(__DIR__));

require_once '../Routes/web.php';

$app->run();

