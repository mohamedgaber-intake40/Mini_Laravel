<?php

namespace app\Providers;


use Core\Request;
use Core\Support\ServiceProvider;

class InstanceServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->application->instance(Request::class,function (){
            return Request::getInstance();
        });
    }
}