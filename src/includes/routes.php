<?php

/**
 * route format:
 * <part>/<part>/<...args>
 * all args will be supplied to controller method
 */

// Admin controller routes
$website->addRoute('admin/dashboard', ['GET'], ['Admin', 'dashboard'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);

// Auth controller routes
$website->addRoute('auth/login', ['GET', 'POST'], ['Auth', 'login']);
$website->addRoute('auth/logout', ['GET', 'POST'], ['Auth', 'logout']);
$website->addRoute('auth/dropbox', ['GET'], ['Auth', 'authorizeDropbox'],
    true, \Utopix\Entity\User::EDIT_POST);
$website->addRoute('auth/save-dropbox-token', ['GET'], ['Auth', 'saveDropboxToken'],
    true, \Utopix\Entity\User::EDIT_POST);

// Posts controller routes
$website->addRoute('posts/home', ['GET'], ['Posts', 'homePage']);
$website->addRoute('posts/list', ['GET'], ['Posts', 'list']);
$website->addRoute('posts/get', ['GET'], ['Posts', 'get']);
$website->addRoute('posts/create', ['GET', 'POST'], ['Posts', 'create'],
    true, \Utopix\Entity\User::EDIT_POST);
$website->addRoute('posts/update', ['GET', 'POST'], ['Posts', 'update'],
    true, \Utopix\Entity\User::EDIT_POST);
$website->addRoute('posts/delete', ['POST'], ['Posts', 'delete'],
    true, \Utopix\Entity\User::DELETE_POST);

// Users controller routes
$website->addRoute('users/list', ['GET'], ['Users', 'list'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);
$website->addRoute('users/get', ['GET'], ['Users', 'get']);
$website->addRoute('users/create', ['GET', 'POST'], ['Users', 'create']);
$website->addRoute('users/update', ['GET', 'POST'], ['Users', 'update']);
$website->addRoute('users/delete', ['Post'], ['Users', 'delete'], true);

// Categories controller routes
$website->addRoute('categories/list', ['GET'], ['Categories', 'list']);
$website->addRoute('categories/get', ['GET'], ['Categories', 'get']);
$website->addRoute('categories/create', ['GET', 'POST'], ['Categories', 'create'],
    true, \Utopix\Entity\User::EDIT_CATEGORY);
$website->addRoute('categories/update', ['GET', 'POST'], ['Categories', 'update'],
    true, \Utopix\Entity\User::EDIT_CATEGORY);
$website->addRoute('categories/delete', ['Post'], ['Categories', 'delete'],
    true, \Utopix\Entity\User::DELETE_CATEGORY);

// Comments controller routes
$website->addRoute('comments/list', ['GET'], ['Comments', 'list'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);
$website->addRoute('comments/get', ['GET'], ['Comments', 'get'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);
$website->addRoute('comments/create', ['POST'], ['Comments', 'create'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);
$website->addRoute('comments/update', ['POST'], ['Comments', 'update'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);
$website->addRoute('comments/delete', ['POST'], ['Comments', 'delete'],
    true, \Utopix\Entity\User::EDIT_USER_ACCESS);

// Error routes
$website->addRoute('error/404', ['GET'], ['Errors', 'pageNotFound']);
$website->addRoute('error/401', ['GET'], ['Errors', 'authenticationRequired']);
$website->addRoute('error/403', ['GET'], ['Errors', 'forbidden']);
$website->addRoute('error/500', ['GET'], ['Errors', 'InternalServerError']);