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
    return Router::get_instance()->getParsedRoute($name,$params);
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

function app()
{
    return \Core\Application::getInstance();
}

function request()
{
    return \Core\Request::getInstance();
}

function view($view,$data=[])
{
    extract($data);
    $path_arr = explode('.',$view);
    $file_path = implode('/',$path_arr);
    $full_path =  ROOT . 'views/' . $file_path . '.php';
    return require ($full_path);
}
