<?php

namespace Core;

use app\Exceptions\Handler;

class Application
{
    private $bindings ;
    private $providers;
    private $router;
    private static $instance;

    public function __construct()
    {
        $this->router = Router::get_instance();
        $this->loadProviders();
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function instance($class,$callable )
    {
        $this->bindings[$class] = $callable;
    }

    public function make($concrete)
    {
        $callable = $this->bindings[$concrete] ?? null;
        if(!is_null($callable))
        {
            return $callable();
        }
        if($object = $this->resolveDependenciesAndGetObject($concrete))
        {
            return $object;
        }
        throw new \Exception("can not resolve $concrete");
    }


    public function getRouter()
    {
        return $this->router;
    }

    public function dispatch()
    {
        try {
            $this->router->resolveMatchedRoute();
            $this->callActionAndGetResponse();
        }catch (\Exception $exception){
            Handler::getInstance()->handle($exception);
        }
    }


    private function callActionAndGetResponse()
    {
        $matchedRoute = $this->router->getMatchedRoute();
        $object = $this->resolveDependenciesAndGetObject($matchedRoute->controller);
        $parameters = $this->resolveMethodParameters($object,$matchedRoute->actionMethod);

        echo call_user_func_array([$object,$matchedRoute->actionMethod],$parameters);
    }


    private function resolveDependenciesAndGetObject($class)
    {
        $parameters = [];
        $reflector = new \ReflectionClass($class);
        if( $reflector->hasMethod('__construct')
            && $reflector->getMethod('__construct')->getNumberOfParameters()
        ){
            foreach ($reflector->getMethod('__construct')->getParameters() as $parameter)
            {
                if($parameter->getType() && !$parameter->getType()->isBuiltin()){
                    $parameters [] = $this->make($parameter->getType()->getName());
                }
            }
        }
        return new $class(...$parameters);
    }

    private function resolveMethodParameters($object, $method)
    {
        $parameters = [] ;
        $reflector = new \ReflectionClass($object);
        if($reflector->hasMethod($method))
        {
            foreach ($reflector->getMethod($method)->getParameters() as $parameter)
            {
                if($parameter->getType() && !$parameter->getType()->isBuiltin()){
                    $parameters [] = $this->make($parameter->getType()->getName());
                }
                else
                {
                    $request = Request::getInstance();
                    $parameterName = $parameter->getName();
                    if($parameterValue = $request->$parameterName)
                        $parameters[] = $parameterValue;
                }
            }
        }
        else
        {
            $class = get_class($object);
            throw new \Exception("$class does not have method $method");
        }
        return $parameters;
    }

    private function loadProviders()
    {
        $providers  = (require ROOT.'Config/app.php')['providers'];
        foreach ($providers as $provider) {
            $provider = new $provider($this);
            $this->providers [] = $provider;
            $provider->register();
        }
    }




}