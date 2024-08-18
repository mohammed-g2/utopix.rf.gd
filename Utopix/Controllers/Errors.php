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
}
