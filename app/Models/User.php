<?php

namespace app\Models;

use Core\QueryBuilder;
use Database\Database;

class User extends BaseModel
{
	private static  $table = "users";
	public $id,$name,$email,$country_id;

    public function __construct($record)
    {
        foreach($record as $attribute => $value)
        {
            if($this->has_attribute($attribute))
            {
                $this->$attribute = $value;
            }
        }
    }

    public static function create($data)
    {
        return Database::insert(self::$table,$data);
    }

    public static function all()
    {
        $users = Database::select(self::$table);
        return self::instantiation($users);

    }

    private static function instantiation($records)
    {
        $result=[];
        foreach ($records as $record)
        {
            $result [] = new self($record);
        }
        return $result;
    }

    public static function query()
    {
        return new QueryBuilder(self::$table);
    }

    public static function where($conditions)
    {
        $diseases = Database::select(self::$table, [], $conditions);
        return self::instantiation($diseases);
    }

//    public function load($relation,$foreign_key,Array $conditions=[],$one = false)
//    {
//        $relation_data=[];
//        $relation_conditions = [$foreign_key=>$this->$foreign_key];
//        $relation_conditions = array_merge($relation_conditions , $conditions);
//        if($this->has_attribute($foreign_key))
//            $relation_data = $relation::where($relation_conditions);
//
//        $relation = strtolower(explode('\\',$relation)[2]);
//
//        if($one){
//            $relation_data = $relation_data[0];
//        }else{
//            $relation .= 's';
//        }
//
//        $this->$relation = $relation_data;
//
//    }



}




