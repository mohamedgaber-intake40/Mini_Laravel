<?php


namespace Core\Validator;


class Validator
{
     private  static $rules_namespace = 'Core\Validator\Rules\\';

     public static function validate( $input , $rules)
     {
         $errors = [];
         $rules = explode('|',$rules);
         foreach ($rules as  $rule)
         {
             $valid_result = self::checkRules($input , $rule );
             if($valid_result !== true)
                 $errors[] = $valid_result;
         }
         return $errors;
     }

     private static function checkRules( $input , $rule )
     {
         $rule = ucfirst($rule);

         if($result = self::getRuleParams($rule)) {
             $rule_class= self::$rules_namespace . $result['rule'] . 'Rule';

             $param1 = isset($result['params'][0]) ? $result['params'][0] :null;
             $param2 = isset($result['params'][1])? $result['params'][1] :null;
             return $rule_class::validate($input,$param1,$param2) ;
         }
            $rule_class= self::$rules_namespace . $rule . 'Rule';

         return $rule_class::validate($input);
     }

     public static function prepare($data)
     {
         $result = [];
         foreach ($data as $key => $value)
         {
             if(is_array($value))
             {
                foreach ($value as $idx => $item)
                {
                    $result[$key][$idx] = htmlentities(stripcslashes(trim(strip_tags($item))));
                }
             }
             else
             {
                $result [$key] = htmlentities(stripcslashes(trim(strip_tags($value))));
             }
         }
         return $result;
     }

     private static function getRuleParams($rule) // 'unique:users,name'
     {
         $idx = strpos($rule ,':');
         if($idx){
             $rule_name = substr($rule , 0 , $idx);
             $params_string = substr($rule , $idx + 1);
             $params = explode(',',$params_string);
             return [
                 'rule'=>$rule_name,
                 'params'=>$params
             ];
         }
         return false;
     }

     public static function validateArray($arr , $key ,$rules)
     {
         $errors = [];
         $tmp_key = $key;
         foreach ($arr as $idx =>$value){
             $idx_key=$key;
             $rule_errors = self::validate($value,$rules);
             if(count($rule_errors))
             {
                 $idx_key .= '.'.$idx;
                 $errors[$idx_key] = $rule_errors;
             }
         }
         return $errors;
     }
}
