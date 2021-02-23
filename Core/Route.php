<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 11:26 AM
 */
namespace Core;

class Route
{
    private  static $router;
    public $url ;
    public $controller;
    public $actionMethod;
    public $requestMethod;
    public $params;
    public  $name;

    public function __construct($url , $action ,$requestMethod)
    {
        $this->parseAction($action);
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->defineParams();
    }

    private function defineParams()
    {
        $matches = [];
        preg_match_all('#\{(.*?)\}#',$this->url,$matches);
        if(isset($matches[1][0]))
        {
            foreach ($matches[1] as $param)
            {
               $this->params[$param] = null;
            }
        }

    }

    public function setParamsValue($values)
    {
        if(count($values)){
            $paramNames = array_keys($this->params);
            foreach ($paramNames as $idx => $name)
            {
                $this->params[$name] = $values[$idx][0] ?? null;
            }
        }


    }

    public static function get($url , $controller)
    {
        self::initializeRouter();
        $url = self::addPrefix($url);
        $route = new Route($url ,$controller,'GET');
        self::$router->registerRoute($route);
        return $route;
    }

    public static function post($url , $controller)
    {
        self::initializeRouter();
        $url = self::addPrefix($url);
        $route = new Route($url ,$controller,'POST');
        self::$router->registerRoute($route);
        return $route;

    }

    public static function put($url , $controller)
    {
        self::initializeRouter();
        $url = self::addPrefix($url);
        $route = new Route($url ,$controller,'PUT');
        self::$router->registerRoute($route);
        return $route;

    }

    public static function delete($url , $controller)
    {
        self::initializeRouter();
        $url = self::addPrefix($url);
        $route = new Route($url ,$controller,'DELETE');
        self::$router->registerRoute($route);
        return $route;

    }

    private static function initializeRouter()
    {
        if(!self::$router)
        {
            self::$router = app()->getRouter();
        }
    }

    public function parseAction($action)
    {
        $this->controller = $action[0];
        $this->actionMethod = $action[1];
    }
    public function name($name)
    {
        $this->name = $name;
    }

    private static  function addPrefix($url)
    {

        return $url == '/' ? URL : URL . $url;
    }


}
