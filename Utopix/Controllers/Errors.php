<?php

namespace Utopix\Controllers;


class Errors
{
    public function __construct() {}

    public function __toString(): string
    {
        return '<Controller Errors>';
    }

    public function pageNotFound()
    {
        return [
            'template' => 'errors/404.html.php'
        ];
    }

    public function authenticationRequired()
    {
        return [
            'template' => 'errors/401.html.php'
        ];
    }

    public function forbidden()
    {
        return [
            'template' => 'errors/403.html.php'
        ];
    }

    public function InternalServerError()
    {
        return [
            'template' => 'errors/500.html.php'
        ];
    }
}
