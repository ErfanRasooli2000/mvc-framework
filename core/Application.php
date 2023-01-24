<?php

namespace App\core;

class Application
{
    public Router $router;
    public Request $request;

    public static string $rootpath;

    public function __construct($path)
    {
        self::$rootpath = $path;
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}