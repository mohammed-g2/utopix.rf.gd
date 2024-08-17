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
    private Authentication $authentication;
    private array $routes;

    public function __construct()
    {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        $this->pdo = $pdo;
        $this->users = new DatabaseTable(
            $this->pdo, 'users', 'id', 'Utopix\Entity\User', [&$this->posts]);
        $this->posts = new DatabaseTable(
            $this->pdo, 'posts', 'id', '\Utopix\Entity\Post', [&$this->users]);
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
        return '/';
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
        $found = false;
        foreach ($this->routes as $key => $val) {
            if ($key === $uri && isset($this->routes[$key][$method])) {
                $controllerName = $this->routes[$key][$method]['controllerClass'];
                
                if ($controllerName === 'Posts') {
                    $controller = new \Utopix\Controllers\Posts($this->posts);
                }

                $this->routes[$key][$method]['controllerClass'] = $controller;
                return $this->routes[$key][$method];
            }
        }
        if (!$found) {
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
        string $method,
        array $controller,
        bool $requireAuth = false,
        int $permissionsRequired = 0
    ) {
        $this->routes[$uri][$method]['controllerClass'] = $controller[0];
        $this->routes[$uri][$method]['controllerView'] = $controller[1];
        $this->routes[$uri][$method]['requireAuth'] = $requireAuth;
        $this->routes[$uri][$method]['permissionsRequired'] = $permissionsRequired;
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
    public function getTemplateContext(): array {
        return [
            'current_user' => $this->authentication->getCurrentUer(),
            'is_authenticated' => $this->authentication->isAuthenticated(),
            'permissions' => []
        ];
    }
}
