<?php

namespace Utopix\Controllers;

use \Ninja\Controller;

class Posts implements Controller
{
    public function __construct() {}

    public function homePage(): array {
        return [
            'template' => 'index.html.php'
        ];
    }

    public function list(): array {
        return [
            'template' => 'posts/list.html.php'
        ];
    }

    public function get(string $id): array {
        return [];
    }

    public function create(): array|null {
        return [];
    }

    public function update(string $id): array|null {
        return [];
    }

    public function delete(string $id): void {
        return;
    }
}
