<?php


namespace Core\Validator\Rules;


//use Includes\Database\Database;

use Database\Database;

class UniqueRule implements Rule
{
    private static $db;

    public static function validate($value , $table = null , $key = null)
    {
        if(isset($value) && !empty($value)){
        self::$db = Database::getInstance();
        $result = self::$db->select($table,[],[$key=>$value]);
        $count = !empty($result);
        return $count ? 'Registered Before.' : true;
        }
        return true;
    }

}
