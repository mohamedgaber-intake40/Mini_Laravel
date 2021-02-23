<?php

namespace app\Exceptions;
use Core\Exceptions\ExceptionHandler;
use Core\Exceptions\ModelNotFoundException;
use Core\Exceptions\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function handle(Throwable $exception)
    {
       if($exception instanceof ModelNotFoundException || $exception instanceof RouteNotFoundException)
       {
           if(!request()->ajax())
                require_once ROOT.'views/404.php';
           else
               return json_response(['message' => $exception->getMessage()],404);
       }
    }
}