<?php

use App\core\Router;

Router::get('/' , 'home');
Router::get('/contact' , 'contact');
Router::post('/contact' , function (){
    return "hi";
});