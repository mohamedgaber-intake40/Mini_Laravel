<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 12:03 PM
 */

function autoLoader($class)
{
    $path = __DIR__ .'/'. $class . '.php';
    $path =  str_replace('\\', '/', $path);

    if (is_file($path)) {
        require($path);
    } else {
        die('class ' . $path . ' does not exist');
    }
}

spl_autoload_register('autoloader');
