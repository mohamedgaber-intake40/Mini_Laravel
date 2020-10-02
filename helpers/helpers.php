<?php

use Core\Router;

/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 4:53 PM
 */

function route($name , $params = null)
{
    $routes = Router::$routes;
    $found_route = '';
    foreach ($routes as $route)
    {
        if($route->name == $name)
            $found_route = $route->url;
    }
    if($params)
    {
        $found_route =str_replace(':','',$found_route);
        foreach ($params as $key => $param)
        {
            $found_route = preg_replace('/'.$key.'\b/', $param, $found_route);
        }
    }
    return !empty($found_route) ? $found_route : die("404 NOT FOUND ROUTE NAME $name") ;

}

function json_response( Array $message = [] , $code = 200)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    );
    // ok, validation error, or failure
    header('Status: '.$code);

    return json_encode(array(
        'status' => $code == 200, // success or not?
    ) + $message );
}

function redirect($path)
{
    header("location: " . $path );
}

function assets($path)
{
    return URL .'public/'. $path;
}
