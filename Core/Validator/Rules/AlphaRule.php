<?php


namespace Core\Validator\Rules;


class AlphaRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
        return preg_match('/^[a-zA-Z]+$/',$value) ? true : 'Must be Alpha only';
    }
}
