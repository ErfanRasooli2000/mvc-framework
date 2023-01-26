<?php

namespace App\core;

class Router
{
    protected static array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request , Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = self::$routes[$method][$path] ?? false;

        if(is_string($callback))
        {
            return $this->renderView($callback);
        }

        if(!$callback)
        {
            $this->response->setStatusCode(404);
            return "404 - Not Found";
        }
        else
        {
            return call_user_func($callback);
        }
    }

    public function renderView($view)
    {
        $main = $this->layoutContent();
        $view = $this->view_to_string(Application::$rootpath . "/Views/$view.php");
        return str_replace('{{content}}' , $view , $main);
    }

    protected function layoutContent()
    {
        return  $this->view_to_string(Application::$rootpath . '/Views/layouts/layout.php');
    }

    public function view_to_string($viewPath)
    {
        ob_start();
        include_once $viewPath;
        return ob_get_clean();
    }

    public static function get($path , $callback)
    {
        self::$routes['get'][$path] = $callback;
    }

    public static function post($path , $callback)
    {
        self::$routes['post'][$path] = $callback;
    }
}