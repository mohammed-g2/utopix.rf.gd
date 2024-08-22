<?php

namespace Utopix\Controllers;

use \DateTime;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;
use \Ninja\Controller;

class Posts implements Controller
{
    private DatabaseTable $posts;
    private DatabaseTable $categories;
    private Authentication $authentication;

    public function __construct(DatabaseTable $posts, DatabaseTable $categories,
            Authentication $authentication) {
        $this->posts = $posts;
        $this->categories = $categories;
        $this->authentication = $authentication;
    }

    public function __toString(): string
    {
        return '<Controller Posts>';
    }

    /**
     * the website's landing page
     */
    public function homePage(): array {
        // $posts = $this->posts->getAll('updated_at DESC', 11);
        // $trending = $this->posts->getAll('visits DESC', 4);
        return [
            'template' => 'index.html.php',
            'variables' => [
                'posts' => [],
                'trending' => []
            ]
        ];
    }

    /**
     * method GET, return a list of posts
     */
    public function list(): array {
        $page = $_GET['page'] ?? 1;
        $perPage = 5;
        $pages = ceil($this->posts->total() / $perPage);
        $posts = $this->posts->getAll('updated_at DESC', $perPage, ($page - 1) * $perPage);
        return [
            'template' => 'posts/list.html.php',
            'variables' => [
                'posts' => $posts,
                'page' => $page,
                'perPage' => $perPage,
                'pages' => $pages,
                'url' => '/posts/list'
            ]
        ];
    }

    public function listByCategory(string $category): array { 
        return [];    
    }

    /**
     * method GET, get post by id
     */
    public function get(string $id): array {
        return [
            'template' => 'posts/post.html.php'
        ];
    }

    /**
     * method GET, return the create a new post form
     * method POST, attempt to create a new post then redirect
     */
    public function create(): array|null {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($_POST['title'])) {
                $errors[] = 'post title cannot be empty';
            }
            if (empty($_POST['body'])) {
                $errors[] = 'post content cannot be empty';
            }
            if (!empty($this->posts->filterBy(['title' => $_POST['title']]))) {
                $errors[] = 'please choose another title';
            }

            $upload = upload_image($_FILES['img']);

            if (is_array($upload)) {
                $errors = array_merge($upload, $errors);
            }

            if (empty($errors)) {
                $post = $this->posts->save([
                    'title' => $_POST['title'],
                    'body' => $_POST['body'],
                    'updated_at' => new DateTime(),
                    'user_id' => $this->authentication->getCurrentUer()->id,
                    'visits' => 0,
                    'publish' => true,
                    'img_url' => '/assets/images/' . $upload,
                    'category_id' => $_POST['category_id']
                ]);

                header('location: /posts/list');
                exit;
            }
            else {
                return [
                    'template' => 'posts/create.html.php',
                    'flashedMsgs' => $errors,
                    'variables' => [
                        'post' => [
                            'title' => $_POST['title'],
                            'body' => $_POST['body'],
                            'category_id' => $_POST['category_id'],
                        ],
                        'categories' => $this->categories->getAll()
                    ]
                ];
            }
        }
        return [
            'template' => 'posts/create.html.php',
            'variables' => [
                'categories' => $this->categories->getAll()
            ]
        ];
    }

    /**
     * method GET, return the update post form
     * method POST, attempt to update the post then redirect
     */
    public function update(string $id): array|null {
        return [
            'template' => 'posts/update.html.php'
        ];
    }

    /**
     * method POST, attempt to delete post then redirect
     */
    public function delete(): void {
        return;
    }
}
