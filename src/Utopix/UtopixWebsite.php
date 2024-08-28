<?php

namespace Utopix;

use \PDO;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;
use \Ninja\Website;

class UtopixWebsite implements Website
{
    private PDO $pdo;
    private ?DatabaseTable $users;
    private ?DatabaseTable $posts;
    private ?DatabaseTable $categories;
    private Authentication $authentication;
    private array $routes;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->users = new DatabaseTable(
            $this->pdo,
            'users',
            'id',
            'Utopix\Entity\User',
            [&$this->posts]
        );
        $this->posts = new DatabaseTable(
            $this->pdo,
            'posts',
            'id',
            '\Utopix\Entity\Post',
            [&$this->users, &$this->categories]
        );
        $this->categories = new DatabaseTable(
            $this->pdo, 
            'categories', 
            'id',
        'Utopix\Entity\Category',
        [&$this->posts]);
        $this->authentication = new Authentication($this->users, 'email', 'password');
        $this->routes = [];
    }

    public function __toString()
    {
        return '<Website Utopix>';
    }

    /**
     * get default uri for the website
     */
    public function getDefaultRoute(): string
    {
        return 'posts/home';
    }

    /** 
     * return an array of:
     * ['controllerClass' => classInstance,
     * 'controllerView' => [
     *      'method' => 'methodName',
     *      'vars' => 'method variables'
     * ],
     * 'requireAuth' => bool,
     * 'permissionsRequired' => int]
     */
    public function getController(string $uri, string $method): array|null
    {
        $controllers = [
            'Posts' => new \Utopix\Controllers\Posts(
                $this->posts,
                $this->categories,
                $this->authentication
            ),
            'Users' => new \Utopix\Controllers\Users($this->users, $this->authentication),
            'Categories' => new \Utopix\Controllers\Categories($this->categories),
            'Auth' => new \Utopix\Controllers\Auth($this->users, $this->authentication),
            'Errors' => new \Utopix\Controllers\Errors()
        ];

        $parts = explode('/', $uri);
        $main = array_shift($parts) . '/' . array_shift($parts);

        if (isset($this->routes[$main])) {
            $route = $this->routes[$main]['methods'][$method];
            return [
                'controllerClass' => $controllers[$route['controllerClass']],
                'controllerView' => [
                    'method' => $route['controllerView'],
                    'vars' => $parts
                ],
                'requireAuth' => $route['requireAuth'],
                'permissionsRequired' => $route['permissionsRequired']
            ];
        }
        else {
            return null;
        }
    }

    /**
     * check if given uri require authentication
     */
    public function uriAuthenticated(string $uri, string $method): string|null
    {
        return $this->routes[$uri][$method]['requireAuth'];
    }

    /**
     * add route to a list of routes
     */
    public function addRoute(
        string $uri,
        array $methods,
        array $controller,
        bool $requireAuth = false,
        int $permissionsRequired = 0
    ) {
        $this->routes[$uri]['methods'] = $methods;
        foreach ($methods as $method) {
            $this->routes[$uri]['methods'][$method]['controllerClass'] = $controller[0];
            $this->routes[$uri]['methods'][$method]['controllerView'] = $controller[1];
            $this->routes[$uri]['methods'][$method]['requireAuth'] = $requireAuth;
            $this->routes[$uri]['methods'][$method]['permissionsRequired'] = $permissionsRequired;
        }
    }

    /**
     * return a list of all routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * get variable available to all templates
     */
    public function getTemplateContext(): array
    {
        return [
            'currentUser' => $this->authentication->getCurrentUer(),
            'isAuthenticated' => $this->authentication->isAuthenticated(),
            'permissions' => [
                'EDIT_POST' => \Utopix\Entity\User::EDIT_POST,
                'DELETE_POST' => \Utopix\Entity\User::DELETE_POST,
                'EDIT_CATEGORY' => \Utopix\Entity\User::EDIT_CATEGORY,
                'DELETE_CATEGORY' => \Utopix\Entity\User::DELETE_CATEGORY,
                'EDIT_USER_ACCESS' => \Utopix\Entity\User::EDIT_USER_ACCESS
            ]
        ];
    }

    /**
     * get authentication instance
     */
    public function getAuth(): Authentication
    {
        return $this->authentication;
    }
}
