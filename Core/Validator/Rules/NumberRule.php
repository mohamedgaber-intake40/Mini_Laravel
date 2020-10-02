<?php


namespace Core\Validator\Rules;


class NumberRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
        return preg_match('/^[0-9]+$/',$value) ? true : 'Must be Numbers only';
    }
}
