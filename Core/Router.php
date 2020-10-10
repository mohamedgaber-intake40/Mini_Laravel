<?php
namespace Core;


class Router
{
    public static $routes = [];
    private static $instance;

    /**
     * @param $url
     * @param $request
     * @throws \Exception
     */
    static public function parse($url, $request)
    {

        foreach (self::$routes as $route)
            {

                if(self::validateRoute($route->url ,$request) && $route->request_method == $request->method )
                {
                    $request->controller = $route->controller;
                    $request->action = $route->controller_action;
                    break;
                }

            }
            if(!isset($request->controller) || !isset($request->action)){
//                die('404 Not Found'); // TODO UPDATE
                throw new \Exception("404 Not Found Route: $request->url" );
            }

    }

    public  function registerRoute(Route $route)
    {
        self::$routes[] = $route;
    }

    public static function get_instance()
    {
        if(!self::$instance)
            return self::$instance = new Router();
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

}
?>
