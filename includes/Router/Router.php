<?php

namespace Elias\Wpvfr\Router;

class Router
{
    public function __construct()
    {
        if(is_admin()){
            new Admin();
        }
        new Frontend();
    }
}