<?php


namespace Core\Validator\Rules;


class MinRule implements Rule
{

    public static function validate($value, $length = null, $key = null)
    {
        return strlen($value) < $length ?   'Must be ' . $length . ' at minimum' : true;
    }
}
