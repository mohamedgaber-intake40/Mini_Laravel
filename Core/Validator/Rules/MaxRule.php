<?php


namespace Core\Validator\Rules;


class MaxRule implements Rule
{

    public static function validate($value, $length = null, $key = null)
    {
        return strlen($value) <= $length ? true : 'Must be ' . $length . ' at maximum';
    }
}
