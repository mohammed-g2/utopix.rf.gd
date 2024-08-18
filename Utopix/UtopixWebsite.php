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
    private ?DatabaseTable $postCategories;
    private Authentication $authentication;
    private array $routes;

    public function __construct()
    {
        include __DIR__ . '/../includes/DatabaseConnection.php';
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
            [&$this->users, &$this->postCategories]
        );
        $this->categories = new DatabaseTable(
            $this->pdo, 
            'categories', 
            'id',
        'Utopix\Entity\Category',
        [&$this->posts]);
        $this->postCategories = new DatabaseTable($this->pdo, 'post_category', 'category_id');
        $this->authentication = new Authentication($this->users, 'email', 'password');
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
     * 'controllerView' => 'methodName',
     * 'requireAuth' => bool,
     * 'permissionsRequired' => int]
     */
    public function getController(string $uri, string $method): array|null
    {
        $uriParts = $this->getParts($uri);
        $controllerName = null;
        foreach ($this->routes as $routeName => $val) {
            $_ = $routeName;
            if ($uriParts['main'] === explode('/', $_)) {
                $controllerName = $this->routes[$routeName]['methods'][$method]['controllerClass'];
            }
        }
        $controllers = [
            'Posts' => new \Utopix\Controllers\Posts(
                $this->posts,
                $this->categories,
                $this->authentication
            ),
            'Users' => new \Utopix\Controllers\Users($this->users),
            'Categories' => new \Utopix\Controllers\Categories($this->categories),
            'Auth' => new \Utopix\Controllers\Auth($this->users, $this->authentication),
            'Errors' => new \Utopix\Controllers\Errors()
        ];

        if ($controllerName) {
            $this->routes[$uri]['methods'][$method]['controllerClass'] = $controllers[$controllerName];
            $this->routes[$uri]['methods'][$method]['vars'] = $uriParts['vars'];
            return $this->routes[$uri]['methods'][$method];
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

    private function getParts($uri): array
    {
        $parts = explode('/', $uri);
        return [
            'main' => [array_shift($parts), array_shift($parts)],
            'vars' => $parts];
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
            'current_user' => $this->authentication->getCurrentUer(),
            'is_authenticated' => $this->authentication->isAuthenticated(),
            'permissions' => []
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
