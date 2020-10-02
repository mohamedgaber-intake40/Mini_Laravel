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
    public $controller_action;
    public $request_method;
    public $params;
    public  $name;

    public function __construct($url , $controller ,$request_method)
    {
        $this->parseController($controller);
        $this->url = $url;
        $this->request_method = $request_method;
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
            self::$router = Router::get_instance();
        }
    }

    public function parseController($controller)
    {
        $arr = explode('@',$controller);
        $this->controller = $arr[0];
        $this->controller_action = $arr[1];
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
