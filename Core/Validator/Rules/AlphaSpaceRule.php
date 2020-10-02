<?php


namespace Core\Validator\Rules;


class AlphaSpaceRule implements Rule
{

    public static function validate($value, $table = null, $key = null)
    {
//        return preg_match('/^[a-zA-Z ]*[a-zA-Z][ a-zA-Z].$/',$value) ? true : 'Must be Alpha and Spaces only';
        return preg_match('/^[a-zA-Z ]*[a-zA-Z][a-zA-Z ]*$/',$value) ? true : 'Must be Alpha and Spaces only';
    }
}
