<?php

namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Controller;

class Posts implements Controller
{
    private DatabaseTable $posts;

    public function __construct(DatabaseTable $posts) {
        $this->posts = $posts;
    }

    /**
     * the website's landing page
     */
    public function homePage(): array {
        return [
            'template' => 'index.html.php'
        ];
    }

    /**
     * method GET, return a list of posts
     */
    public function list(): array {
        return [
            'template' => 'posts/list.html.php'
        ];
    }

    /**
     * method GET, get post by id
     */
    public function get(string $id): array {
        return [];
    }

    /**
     * method GET, return the create a new post form
     * method POST, attempt to create a new post then redirect
     */
    public function create(): array|null {
        return [];
    }

    /**
     * method GET, return the update post form
     * method POST, attempt to update the post then redirect
     */
    public function update(string $id): array|null {
        return [];
    }

    /**
     * method POST, attempt to delete post then redirect
     */
    public function delete(): void {
        return;
    }
}
