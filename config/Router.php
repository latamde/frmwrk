<?php

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve($request_method, $request_uri)
    {
        $public_dir = $_SERVER['DOCUMENT_ROOT'] . '/public';
        $file_path = $public_dir . $request_uri;

        if (isset($this->routes[$request_method])) {
            foreach ($this->routes[$request_method] as $route => $action) {
                $pattern = str_replace('/', '\/', $route);
                $pattern = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $pattern);
                $pattern = '/^' . $pattern . '$/';

                if (preg_match($pattern, $request_uri, $matches)) {
                    $action($matches);
                    return true;
                }
            }
        }

        return false;
    }
}
