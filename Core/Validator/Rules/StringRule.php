<?php


namespace Core\Validator\Rules;


class StringRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
        return preg_match('/^[a-zA-Z0-9 ]*[a-zA-Z0-9][a-zA-Z0-9 ]*$/',$value) ? true : 'Must be String only';
    }
}
