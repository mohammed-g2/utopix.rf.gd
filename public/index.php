<?php

include __DIR__ . '/../includes/autoload.php';
include_once __DIR__ . '/../includes/functions.php';

use \Utopix\UtopixWebsite;
use \Ninja\EntryPoint;

$website = new UtopixWebsite();
$entryPoint = new EntryPoint($website);

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
$method = $_SERVER['REQUEST_METHOD'];

$website->addRoute('posts/list', 'GET', ['Posts', 'list']);
$website->addRoute('/', 'GET', ['Posts', 'homePage']);

$entryPoint->run($uri, $method);
