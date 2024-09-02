<?php

namespace Utopix\Controllers;


class Admin {
    public function __construct()
    {
        
    }

    public function __toString()
    {
        return '<Controller Admin>';
    }

    public function dashboard(array $environ)
    {
        return [
            'template' => 'admin/dashboard.html.php'
        ];
    }
}