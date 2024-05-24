<?php

class Router
{
    private $routes = [];

    // public function get($path, $callback)
    // {
    //     $this->routes['GET'][$path] = $callback;
    // }

    // public function post($path, $callback)
    // {
    //     $this->routes['POST'][$path] = $callback;
    // }

    // public function resolve($request_method, $request_uri)
    // {
    //     $public_dir = $_SERVER['DOCUMENT_ROOT'] . '/public';
    //     $file_path = $public_dir . $request_uri;

    //     if (isset($this->routes[$request_method])) {
    //         foreach ($this->routes[$request_method] as $route => $action) {
    //             $pattern = str_replace('/', '\/', $route);
    //             $pattern = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $pattern);
    //             $pattern = '/^' . $pattern . '$/';

    //             if (preg_match($pattern, $request_uri, $matches)) {
    //                 $action($matches);
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }
    
    public function get($pattern, $callback)
    {
        $this->addRoute('GET', $pattern, $callback);
    }

    public function post($pattern, $callback)
    {
        $this->addRoute('POST', $pattern, $callback);
    }


    private function addRoute($method, $pattern, $callback)
    {
        $this->routes[$method][$pattern] = $callback;
    }

    public function resolve($method, $path)
{
    foreach ($this->routes[$method] as $pattern => $callback) {
        if (preg_match($this->patternToRegex($pattern), $path, $matches)) {
            $params = [];
            foreach ($matches as $key => $value) {
                if (!is_int($key)) {
                    $params[$key] = $value;
                }
            }
            $callback($params);
            return true;
        }
    }

    return false;
}

    private function patternToRegex($pattern)
    {
        return '#^' . preg_replace_callback(
            '/{([^\/]+)}/',
            function ($matches) {
                return '(?P<' . $matches[1] . '>[^\/]+)';
            },
            $pattern
        ) . '$#';
    }
}
