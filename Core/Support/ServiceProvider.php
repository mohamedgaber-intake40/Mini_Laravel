<?php


namespace Core\Support;


use Core\Application;

abstract class ServiceProvider
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public abstract function register();

    protected function loadRoutes($path)
    {
        require_once (ROOT . $path);
    }


}