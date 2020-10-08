<?php

namespace app\Models;

use Core\QueryBuilder;
use Database\Database;

interface Model
{

    public static function create($data);

    public static function all();

    public static function query();

    public static function where($conditions);

    public function load($relation,$primary_key,$foreign_key,Array $conditions=[],$one = false);

}




