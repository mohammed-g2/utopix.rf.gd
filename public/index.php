<?php

$env = parse_ini_file(__DIR__ . '/../.env');

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/includes/functions.php';
include_once __DIR__ . '/../src/includes/DatabaseConnection.php';

use \Utopix\UtopixWebsite;
use \Ninja\EntryPoint;

$website = new UtopixWebsite($pdo);
$entryPoint = new EntryPoint($env, $website);

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
if ($uri === false) {
    $uri = '';
}

$method = $_SERVER['REQUEST_METHOD'];

include_once __DIR__ . '/../src/includes/routes.php';

$entryPoint->run($uri, $method, $env);
