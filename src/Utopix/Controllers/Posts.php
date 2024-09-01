<?php

namespace Utopix\Controllers;

use \DateTime;
use Exception;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;
use \Ninja\Controller;
use \Ninja\Dropbox;

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
    public function homePage(array $environ): array {
        $posts = $this->posts->getAll('updated_at DESC', 11);
        $trending = $this->posts->getAll('visits DESC', 4);
        return [
            'template' => 'index.html.php',
            'variables' => [
                'posts' => $posts,
                'trending' => $trending,
                'hero' => array_shift($posts),
                'main' => array_slice($posts, 0, 5),
                'secondary' => array_slice($posts, 5)
            ]
        ];
    }

    /**
     * method GET, return a list of posts
     */
    public function list(array $environ): array {
        $page = $environ['GET']['page'] ?? 1;
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

    /**
     * method GET, get post by id
     */
    public function get(array $environ, string $id): array {
        $post = $this->posts->getById($id);
        if ($post ===false) {
            http_response_code(404);
            header('location: /error/404');
            exit;
        }
        $this->posts->save([
            'id' => $post->id,
            'visits' => $post->visits + 1,
        ]);
        return [
            'template' => 'posts/post.html.php',
            'variables' => [
                'post' => $post
            ]
        ];
    }

    /**
     * method GET, return the create a new post form
     * method POST, attempt to create a new post then redirect
     */
    public function create(array $environ): array|null {
        $dropbox = new Dropbox();
        $dropbox->checkAuthorized();

        if ($environ['SERVER']['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($environ['POST']['title'])) {
                $errors[] = 'post title cannot be empty';
            }
            if (empty($environ['POST']['body'])) {
                $errors[] = 'post content cannot be empty';
            }
            if (!empty($this->posts->filterBy(['title' => $environ['POST']['title']]))) {
                $errors[] = 'please choose another title';
            }

            if (empty($errors)) {
                $upload = $dropbox->uploadImage($environ['FILES']['img']);
            }
            
            if (isset($upload['errors'])) {
                $errors = array_merge($upload['errors'], $errors);
            }

            if (empty($errors)) {
                $post = $this->posts->save([
                    'title' => $environ['POST']['title'],
                    'body' => $environ['POST']['body'],
                    'updated_at' => new DateTime(),
                    'created_at' => new DateTime(),
                    'user_id' => $this->authentication->getCurrentUer()->id,
                    'visits' => 0,
                    'publish' => true,
                    'img_url' => $upload['link'],
                    'img_path' => $upload['path'],
                    'category_id' => $environ['POST']['category_id']
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
                            'title' => $environ['POST']['title'],
                            'body' => $environ['POST']['body'],
                            'category_id' => $environ['POST']['category_id'],
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
    public function update(array $environ, string $id): array|null {
        $dropbox = new Dropbox();
        $dropbox->checkAuthorized();
        
        $post = $this->posts->getById($id);
        if ($post === false) {
            http_response_code(404);
            header('location: /error/404');
            exit;
        }

        if ($environ['SERVER']['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($environ['POST']['title'])) {
                $errors[] = 'post title cannot be empty';
            }
            if (empty($environ['POST']['body'])) {
                $errors[] = 'post content cannot be empty';
            }
            if (!empty($this->posts->filterBy(['title' => $environ['POST']['title']]))
                    && $environ['POST']['title'] != $post->title) {
                $errors[] = 'please choose another title';
            }

            if (empty($errors)) {
                $upload = $dropbox->uploadImage($environ['FILES']['img']);
            }

            if (isset($upload['errors'])) {
                $errors = array_merge($errors, $upload['errors']);
            }
            else {
                // delete old image if another one is uploaded
                if (isset($post->img_path)) {
                    $dropbox->delete($post->img_path);
                }
            }

            if (empty($errors)) {
                $post = $this->posts->save([
                    'id' => $post->id,
                    'title' => $environ['POST']['title'],
                    'body' => $environ['POST']['body'],
                    'updated_at' => new DateTime(),
                    'publish' => true,
                    'img_url' => $upload['link'],
                    'category_id' => $environ['POST']['category_id'],
                    'img_path' => $upload['path']
                ]);

                header('location: /posts/list');
                exit;
            }
        }
        return [
            'template' => 'posts/create.html.php',
            'flashedMsgs' => $errors ?? [],
            'variables' => [
                'post' => [
                    'title' => $post->title,
                    'body' => $post->body,
                    'category_id' => $post->category_id,
                    'img_url' => $post->img_url
                ],
                'categories' => $this->categories->getAll()
            ]
        ];
    }

    /**
     * method POST, attempt to delete post then redirect
     */
    public function delete(array $environ): void {
        $post = $this->posts->getById($environ['POST']['id']);
        if ($post === false) {
            http_response_code(404);
            header('location: /error/404');
            exit;
        }

        $this->posts->delete($environ['POST']['id']);

        http_response_code(202);
        header('location: /posts/list');
        exit;
    }
}
