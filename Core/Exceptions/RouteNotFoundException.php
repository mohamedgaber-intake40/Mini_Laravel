<?php


namespace Core\Exceptions;


class RouteNotFoundException extends \Exception
{
    protected $message = 'Route Not Found';
}