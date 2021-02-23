<?php

namespace Core\Interfaces;



interface Model
{

    public static function create($data);

    public static function all();

    public static function query();

    public static function where($conditions);

    public function load($relations);

}




