<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 30/09/2020
 * Time: 10:18 ص
 */

namespace app\Models;


use Core\QueryBuilder;
use Database\Database;

class Country extends BaseModel implements Model
{
    private static  $table = "countries";
    public $id , $name ;

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
        $countries = Database::select(self::$table);
        return self::instantiation($countries);
    }

    public static function instantiation($records)
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
        $countries = Database::select(self::$table, [], $conditions);
        return self::instantiation($countries);
    }



    public function has_attribute($attribute)
    {
        return property_exists(static::class,$attribute);

    }
}
