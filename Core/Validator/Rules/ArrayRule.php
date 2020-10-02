<?php


namespace Core\Validator\Rules;


class ArrayRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
        return is_array($value) ? true : 'Must be Array';
    }
}
