<?php

namespace Ninja;

use Error;
use \PDOException;

/**
 * 
 * @method void run(string $uri, string $method) respond to route's request
 */
class EntryPoint
{
    private \Ninja\Website $website;

    /**
     * @param \Ninja\Website $website - a class that implements interface \Ninja\Website
     */
    public function __construct(\Ninja\Website $website)
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

            if (!isset($view)) {
                http_response_code(404);
                $title = 'Page not found';
                $content = '<h1 class="mt-3">Page not found</h1>';
            }
            else {

                try {
                    $controller = new $view['controllerClass']();
                } catch (Error $e) {
                    $controller = '';
                }
                $action = $view['controllerView'];
    
                $uri_vars = [];
                foreach (explode('/', $uri) as $part) {
                    if (str_starts_with($part, '{')) {
                        $part = ltrim($part, '{');
                        $part = rtrim($part, '}');
                        $uri_vars[] = $part;
                    }
                }
    
                if (is_callable([$controller, $action])) {
                    $page = $controller->$action(...$uri_vars);
                    $variables = $page['variables'] ?? [];
                    $content = $this->loadTemplate($page['template'], $variables);
                } 
                else {
                    http_response_code(404);
                    $title = 'Page not found';
                    $content = '<h1 class="mt-3">Page not found</h1>';
                }
            }
        } 
        catch (PDOException $e) {
            $title = 'An error occurred';
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
