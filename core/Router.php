<?php

namespace App\core;

class Router
{
    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path , $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if(is_string($callback))
        {
            return $this->renderView($callback);
        }

        if(!$callback)
        {
            return "404 - Not Found";
        }
        else
        {
            return call_user_func($callback);
        }
    }

    public function renderView($view)
    {
        include_once __DIR__ . "/../Views/".$view.".php";
    }
}