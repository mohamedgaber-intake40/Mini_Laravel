<?php
namespace Core;


use Core\Exceptions\RouteNotFoundException;
use Exception;

class Router
{
    /**
     * @var Route []
     */
    public static $routes = [];
    private static $instance;
    private $matchedRoute;

    public function resolveMatchedRoute()
    {
        $request = Request::getInstance();
        $matches  = [];
        $uri = explode('?',$request->url)[0];
        foreach (self::$routes as $route) {
            $routeUrl = $route->url;
            preg_match_all('#\{(.*?)\}#',$routeUrl , $matches);
            if (!empty($matches[0])) {
                $routeParamsMap[] = $matches[1][0];
                $routeUrl = str_replace($matches[0], '(\w+)', $routeUrl);
                $routeUrl = str_replace('/', '\\/', $routeUrl);
            }


            preg_match_all('#^' . $routeUrl . '$#', $uri, $matches);
            if (isset($matches[0][0])) {
                array_shift($matches);
                $route->setParamsValue($matches);
                $this->matchedRoute = $route;
                $request->setParams($route->params);
                return ;
            }
        }

        throw new RouteNotFoundException("Route [ $uri ] not found");
    }

//    /**
//     * @param $url
//     * @param $request
//     * @throws \Exception
//     */
//    static public function parse($url, $request)
//    {
//
//        foreach (self::$routes as $route)
//            {
//
//                if(self::validateRoute($route->url ,$request) && $route->request_method == $request->method )
//                {
//                    $request->controller = $route->controller;
//                    $request->action = $route->controller_action;
//                    break;
//                }
//
//            }
//            if(!isset($request->controller) || !isset($request->action)){
////                die('404 Not Found'); // TODO UPDATE
//                throw new \Exception("404 Not Found Route: $request->url" );
//            }
//
//    }

    public  function registerRoute(Route $route)
    {
        self::$routes[] = $route;
    }

    public static function get_instance()
    {
        if(!self::$instance)
            self::$instance = new self();

        return self::$instance;
    }
    private static function validateRoute( $route_url , Request $request)
    {

        $route_url_arr = explode('/' , $route_url);
        $request_url_arr = explode('/' , $request->url);
        $request_url_arr = array_slice($request_url_arr,1);
        $route_url_arr = array_slice($route_url_arr,1);

            if(count($route_url_arr) != count($request_url_arr) )
                return false;

        foreach ($route_url_arr as $idx => $piece)
        {
            if(isset($piece[0]) && $piece[0] == ':')
            {
                $param_name = substr($piece ,1);
                $request->params [$param_name] = $request_url_arr[$idx];
                continue;
            }

            if($piece != $request_url_arr[$idx])
                return false;
        }
        return true;
    }

    public function getRoutes()
    {
        return self::$routes;
    }

    public function getMatchedRoute ()
    {
        return $this->matchedRoute;
    }

    public function setMatchedRoute(Route $route)
    {
        $this->matchedRoute = $route;
    }

    private function findRoute($routeName)
    {
        foreach (self::$routes as $route)
        {
            if($route->name == $routeName)
            {
                return $route;
            }
        }
        throw  new RouteNotFoundException($routeName . 'not found');
    }

    public function getParsedRoute($routeName,$params)
    {
        $route = $this->findRoute($routeName);
        $matches = [];
        preg_match_all('#\{(.*?)\}#',$route->url,$matches);
        $url = $route->url;
        foreach ($matches[1] as $idx => $match)
        {
            $url = str_replace($matches[0][$idx],$params[$match],$url);
        }
        return $url;
    }

}

