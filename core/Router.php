<?php

namespace App\core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request , Response $response)
    {
        $this->request = $request;
        $this->response = $response;
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
}