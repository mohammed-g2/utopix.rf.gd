<?php

/**
 * route format:
 * <part>/<part>/<...args>
 * all args will be supplied to controller method
 */

// Auth controller routes
$website->addRoute('auth/login', ['GET', 'POST'], ['Auth', 'login']);
$website->addRoute('auth/logout', ['GET', 'POST'], ['Auth', 'logout']);

// Posts controller routes
$website->addRoute('posts/home', ['GET'], ['Posts', 'homePage']);
$website->addRoute('posts/list', ['GET'], ['Posts', 'list']);
$website->addRoute('posts/get', ['GET'], ['Posts', 'get']);
$website->addRoute('posts/create', ['GET', 'POST'], ['Posts', 'create'],
    true, \Utopix\Entity\User::EDIT_POST);
$website->addRoute('posts/update', ['GET', 'POST'], ['Posts', 'update'],
    true, \Utopix\Entity\User::EDIT_POST);
$website->addRoute('posts/delete', ['POST'], ['Posts', 'homePage'],
    true, \Utopix\Entity\User::DELETE_POST);

// Users controller routes
$website->addRoute('users/list', ['GET'], ['Users', 'list'], true);
$website->addRoute('users/get', ['GET'], ['Users', 'get']);
$website->addRoute('users/create', ['GET', 'POST'], ['Users', 'create']);
$website->addRoute('users/update', ['GET', 'POST'], ['Users', 'update']);
$website->addRoute('users/delete', ['Post'], ['Users', 'delete'], true);

// Error routes
$website->addRoute('error/404', ['GET'], ['Errors', 'pageNotFound']);