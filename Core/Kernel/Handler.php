<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 08/10/2020
 * Time: 04:35
 */
namespace Core\Kernel;

class Handler
{
    private static $factory_namespace = 'Core\Kernel\Factories\\';
    private static $type;

    public static function create($command,$class_name)
    {
        $factory_class = explode(':',$command)[1].'Factory';
        self::$type =  explode(':',$command)[1];
        $factory_class = ucfirst($factory_class);
        $full_class_path = self::$factory_namespace .$factory_class;
        new $full_class_path($class_name,self::$type);
    }
}
