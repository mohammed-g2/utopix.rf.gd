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

    /**
     * @param \Ninja\Website $website - a class that implements interface \Ninja\Website
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
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
        extract($variables);
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
    public function run(string $uri, string $method)
    {
        try {
            $this->checkUri($uri);

            if ($uri === '') {
                $uri = $this->website->getDefaultRoute();
            }

            $view = $this->website->getController($uri, $method);
            $authentication = $this->website->getAuth();

            if (isset($view)) {
                if ($view['requireAuth'] && !$authentication->isAuthenticated()) {
                    http_response_code(401);
                    header('location: /errors/401');
                    exit;
                } 
                else if (isset($view['permissionsRequired'])) {
                    $user = $authentication->getCurrentUer();
                    if ($user !== false && !$user->hasPermission($view['permissionRequired'])) {
                        http_response_code(403);
                        header('location: /errors/403');
                        exit;
                    }
                }
                else {
                    $controller = $view['controllerClass'];
                    $action = $view['controllerView'];

                    if (is_callable([$controller, $action])) {
                        $page = $controller->$action(...$view['vars']);
                        $variables = $page['variables'] ?? [];
                        $content = $this->loadTemplate($page['template'], $variables);
                    }
                }
            } 
            else {
                http_response_code(404);
                header('location: /error/404');
                exit;
            }
        } catch (PDOException $e) {
            $content = 'Unable to connect to database <br>'
                . 'Error: ' . $e->getMessage() . '<br>'
                . 'File: '  . $e->getFile()    . '<br>'
                . 'Line: '  . $e->getLine();
        }

        $layoutVariables = $this->website->getTemplateContext();
        $layoutVariables['content'] = $content;
        echo $this->loadTemplate('layout.html.php', $layoutVariables);
    }
}
