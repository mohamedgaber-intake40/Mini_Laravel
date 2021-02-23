<?php


namespace Core\Exceptions;


class ModelNotFoundException extends \Exception
{
    protected $message = 'Model Not Found';
}