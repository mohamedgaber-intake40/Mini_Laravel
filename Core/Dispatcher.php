<?php
namespace Core;
class Dispatcher
{
    private $request;
    private $controllers_namespace = 'app\Controllers\\';

    public function dispatch()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        $action = $this->request->action;
        echo $controller->$action($this->request);
    }

    public function loadController()
    {
        $name =   $this->controllers_namespace . $this->request->controller;
        $file = ROOT  . $name . '.php';
        $file =  str_replace('\\', '/', $file);
        require_once($file);
        $controller = new $name();
        return $controller;
    }

}

