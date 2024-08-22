<?php
namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Controller;


class Categories implements Controller
{
    private DatabaseTable $categories;

    public function __construct(DatabaseTable $categories)
    {
        $this->categories = $categories;
    }

    public function __toString()
    {
        return '<Controller Category>';
    }

    /**
     * method GET, get list of entries
     */
    public function list(): array
    {
        $categories = $this->categories->getAll();
        return [
            'template' => 'categories/list.html.php',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }

    /**
     * method GET, get single entry
     */
    public function get(string $id): array
    {
        $category = $this->categories->getById($id);
        $posts = $category->getPosts();

        $page = $_GET['page'] ?? 1;
        $perPage = 5;
        $pages = ceil(sizeof($posts) / $perPage);

        return [
            'template' => 'posts/list.html.php',
            'variables' => [
                'posts' => $posts,
                'category' => $category,
                'page' => $page,
                'perPage' => $perPage,
                'pages' => $pages,
                'url' => '/categories/get/' . $id
                ]
        ];
    }

    /**
     * method GET, return the create new entry form
     * method POST, attempt to create the entry then redirect
     */
    public function create(): array|null
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($_POST['name'])) {
                $errors[] = 'name cannot be empty';
            }
            if (!empty($this->categories->filterBy(['name' => $_POST['name']])[0])) {
                $errors[] = 'category name already in use';
            }
            if (empty($_POST['description'])) {
                $errors[] = 'description cannot be empty';
            }
            
            $upload = upload_image($_FILES['img']);

            if (is_array($upload)) {
                $errors = array_merge($upload, $errors);
            }

            if (empty($errors)) {
                $this->categories->save([
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'img_url' => '/assets/images/' . $upload
                ]);

                header('Location: /categories/list');
                exit;
            }
            else {
                return [
                    'template' => 'categories/create.html.php',
                    'flashedMsgs' => $errors,
                    'variables' => [
                        'category' => [
                            'name' => $_POST['name'],
                            'description' => $_POST['description']
                        ]
                    ]
                ];
            }
        }
        return [
            'template' => 'categories/create.html.php'
        ];
    }

    /**
     * method GET, return update entry with given id
     * method POST, attempt to update entry then redirect
     */
    public function update(string $id): array|null
    {
        return [];
    }

    /**
     * method POST, attempt to delete entry then redirect
     */
    public function delete(): void
    {
        return;
    }




}