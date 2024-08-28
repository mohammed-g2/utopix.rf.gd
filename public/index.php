<?php

$env = parse_ini_file(__DIR__ . '/../.env');

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/includes/functions.php';
include_once __DIR__ . '/../src/includes/DatabaseConnection.php';

use \Utopix\UtopixWebsite;
use \Ninja\EntryPoint;

$website = new UtopixWebsite($env, $pdo);
$entryPoint = new EntryPoint($website);

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$method = $_SERVER['REQUEST_METHOD'];

include_once __DIR__ . '/../src/includes/routes.php';

$entryPoint->run($uri, $method, $env);
