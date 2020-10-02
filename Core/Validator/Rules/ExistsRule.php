<?php


namespace Core\Validator\Rules;



use Database\Database;

class ExistsRule implements Rule
{
    private static $db;

    public static function validate($value , $table = null , $key = null)
    {
        if(isset($value)){
            self::$db = Database::getInstance();
            $result = self::$db->select($table,[],[$key=>$value]);
            $count = empty($result);
            return $count ? "Invalid Selected $key = $value." : true;
        }
        return false;
    }

}
