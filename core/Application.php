<?php

namespace App\core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;

    public static string $rootpath;

    public function __construct($path)
    {
        self::$rootpath = $path;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request , $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}