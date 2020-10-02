<?php

namespace Core\Validator\Rules;

class RequiredRule implements Rule
{

   public static function validate($value, $table = null, $key = null)
   {
       if(is_array($value))
           return self::validateArray($value);

       return isset($value) && !empty(trim($value)) ? true : 'is required.';
   }
   private static  function validateArray ($value)
   {
       return isset($value) && !empty($value) ? true : 'is required.';

   }


}
