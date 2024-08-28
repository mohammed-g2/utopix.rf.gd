<?php

namespace Ninja;

use \PDOException;
use \Ninja\Website;

/**
 * 
 * @method void run(string $uri, string $method) respond to route's request
 */
class EntryPoint
{
    private Website $website;
    private array $env;

    /**
     * @param \Ninja\Website $website - a class that implements interface \Ninja\Website
     */
    public function __construct(array $env, Website $website)
    {
        $this->website = $website;
        $this->env = $env;
    }

    public function __toString()
    {
        return '<Class EntryPoint>';
    }
    /**
     * load given template into a buffer and return it
     */
    private function loadTemplate(string $file_name, array $variables): string
    {
        $templateContext = $this->website->getTemplateContext();
        extract($variables);
        extract($templateContext);
        ob_start();
        include __DIR__ . '/../templates/' . $file_name;
        return ob_get_clean();
    }

    /**
     * redirect non lower case uris to lower case version
     */
    private function checkUri(string $uri)
    {
        if ($uri != strtolower($uri)) {
            http_response_code(301);
            header('location: ' . strtolower($uri));
        }
    }

    /**
     * run the application
     */
    public function run(string $uri, string $method, array $env)
    {
        try {
            $this->checkUri($uri);
            if ($uri === '') {
                $uri = $this->website->getDefaultRoute();
            }

            $view = $this->website->getController($uri, $method);
            $authentication = $this->website->getAuth();

            if (isset($view)) {
                if (isset($view['requireAuth']) && $view['requireAuth'] && !$authentication->isAuthenticated()) {
                    http_response_code(401);
                    header('location: /error/401');
                    exit;
                } 
                else if (isset($view['permissionsRequired']) && $view['permissionsRequired'] !== 0) {
                    $user = $authentication->getCurrentUer();
                    if ($user !== false && !$user->hasPermission($view['permissionsRequired'])) {
                        http_response_code(403);
                        header('location: /error/403');
                        exit;
                    }
                }

                $controller = $view['controllerClass'];
                $action = $view['controllerView']['method'];
                if (is_callable([$controller, $action])) {
                    $environ = [
                        'POST' => $_POST,
                        'GET' => $_GET,
                        'FILES' => $_FILES,
                        'SERVER' => $_SERVER,
                        'env' => $this->env
                    ];
                    try {
                        $page = $controller->$action($environ, ...$view['controllerView']['vars']);
                        $variables = $page['variables'] ?? [];
                        $content = $this->loadTemplate($page['template'], $variables);
                    }
                    catch (\Error $e) {
                        if ($env['ENV'] === 'development') {
                            $content = 'An Error occurred <br>'
                            . 'Error: ' . $e->getMessage() . '<br>'
                            . 'File: '  . $e->getFile()    . '<br>'
                            . 'Line: '  . $e->getLine();
                        }
                        else {
                            http_response_code(500);
                            header('location: /error/500');
                            exit;
                        }
                    }
                }
            } 
            else {
                http_response_code(404);
                header('location: /error/404');
                exit;
            }
        } 
        catch (PDOException $e) {
            if ($env['ENV'] === 'development') {
                $content = 'Unable to connect to database <br>'
                . 'Error: ' . $e->getMessage() . '<br>'
                . 'File: '  . $e->getFile()    . '<br>'
                . 'Line: '  . $e->getLine();
            }
            else {
                http_response_code(500);
                header('location: /error/500');
                exit;
            }            
        }

        $layoutVariables = [];
        $layoutVariables['content'] = $content;
        if (isset($page['flashedMsgs'])) {
            $layoutVariables['flashedMsgs'] = $page['flashedMsgs'];
        }
        echo $this->loadTemplate('layout.html.php', $layoutVariables);
    }
}
