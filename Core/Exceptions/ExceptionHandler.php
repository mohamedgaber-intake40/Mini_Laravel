<?php

namespace Core\Exceptions;

use Throwable;

abstract  class ExceptionHandler
{
    private static $instance;

    public static function getInstance()
    {
        if(! self::$instance)
            self::$instance = new static();
        return self::$instance;
    }

    public  abstract function handle(Throwable $exception);
}