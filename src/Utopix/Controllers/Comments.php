<?php

namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Controller;

class Comments implements Controller
{
    private DatabaseTable $comments;

    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    public function __toString()
    {
        return '<Controller Comment>';
    }

    public function list(array $environ): array
    {
        return [];
    }

    public function get(array $environ, string $id): array
    {
        return [];
    }

    public function create(array $environ): ?array
    {
        return [];
    }

    public function update(array $environ, string $id): ?array
    {
        return [];
    }

    public function delete(array $environ): void
    {
        
    }
}