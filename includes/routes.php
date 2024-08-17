<?php

// Posts controller routes
$website->addRoute('/', 'GET', ['Posts', 'homePage']);
$website->addRoute('posts/list', 'GET', ['Posts', 'list']);
$website->addRoute('posts/{id}', 'GET', ['Posts', 'get']);
$website->addRoute('posts/create', 'GET', ['Posts', 'create'], true);
$website->addRoute('posts/create', 'POST', ['Posts', 'create'], true);
$website->addRoute('posts/update/{id}', 'GET', ['Posts', 'update'], true);
$website->addRoute('posts/update/{id}', 'POST', ['Posts', 'update'], true);
$website->addRoute('posts/delete', 'POST', ['Posts', 'homePage'], true);

// Auth controller routes

// Users controller routes

