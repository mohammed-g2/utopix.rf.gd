<?php
namespace Ninja;

interface Website {
    /**
     * returns the website default route
     */
    public function getDefaultRoute(): string;
    /** 
     * return an array of:
     * ['controllerClass' => classInstance,
     * 'controllerView' => 'methodName',
     * 'requireAuth' => bool,
     * 'permissionsRequired' => int]
    */
    public function getController(string $uri, string $method): array|null;
    /**
     * check if the given uri require authentication
     */
    public function uriAuthenticated(string $uri, string $method): string|null;
    /**
     * get variable available to all templates
     */
    public function getTemplateContext(): array;
    /**
     * add route to a list of routes
     */
    public function addRoute(string $uri, string $method, array $controller,
        bool $requireLogin, int $permissionsRequired);
    /**
     * return a list of all routes
     */
    public function getRoutes(): array;
    /**
     * return authentication instance
     */
    public function getAuth(): \Ninja\Authentication;
}
