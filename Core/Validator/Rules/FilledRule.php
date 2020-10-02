<?php


namespace Core\Validator\Rules;


class FilledRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
        $result = true;
        $idx = -1;
        foreach ($value as $key => $item)
        {
            if(isset($item) && empty($item)){
                $result=false;
                $idx = $key;
                break;
            }
        }
        return $result ? true : "Must be Filled at index $idx";
    }
}
