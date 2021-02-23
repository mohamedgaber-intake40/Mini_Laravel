<?php
namespace Core;

use Core\Validator\Validator;

class Request
{
    public $url;
    public $method;
    public $params = [];
    public $body =[];
    public $query;
    public $full_url;
    public $headers;
    private static $instance;

    private function __construct()
    {
        $this->full_url = trim($_SERVER["REQUEST_URI"]);
        $this->url = parse_url($this->full_url , PHP_URL_PATH);
        $this->method = $_SERVER["REQUEST_METHOD"];

        if (!function_exists('getallheaders')) {
            function getallheaders() {
                $headers = [];
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }
        }
                $this->headers = getallheaders();


        $this->get_query_string();

        if(in_array($this->method,['POST','PUT']))
            $this->get_body_data();

        $this->fillRequestWithBody();

    }

    public static function getInstance()
    {
        if(!self::$instance)
            self::$instance = new self;
        return self::$instance;
    }

    private function get_body_data()
    {

        if(isset($this->headers['Content-Type']) && $this->headers['Content-Type'] == 'application/json' )
        {

            $this->body = json_decode(file_get_contents("php://input"),true);

        }

        else if($this->method == 'POST')
             $this->body = $this->getPostData();

        else{
            parse_str(file_get_contents("php://input"),$this->body);
        }

        $this->body = Validator::prepare($this->body);

    }

    public function ajax()
    {
        return $this->headers['Accept'] && $this->headers['Accept'] == 'application/json' ;
    }

    private function getPostData()
    {
        return $_POST;
    }
    public function get_query_string()
    {
        $this->query = parse_url($this->full_url,PHP_URL_QUERY);
        parse_str($this->query ,$this->query);
        $this->query = Validator::prepare($this->query);
    }

    public function validate($key,$value,$rules)
    {
        $errors = [];
        $input_errors = Validator::validate($value,$rules);

        if(count($input_errors)){
            $errors[$key] = $input_errors;
            echo json_response($errors,422);
            exit();
        }
    }

    public function validateArray($key, $value,$rules)
    {
        $errors = [];
        $input_errors = Validator::validateArray($value,$key,$rules);
        if(count($input_errors)){
            $errors[$key] = $input_errors;
            echo json_response($errors,422);
            exit();
        }
    }

    private function fillRequestWithBody()
    {
        foreach ($this->body as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function only($inputs)
    {
        $inputs = func_get_args();
        $result = [];
        foreach ( $inputs as $input)
        {
            if(isset($this->$input))
                $result[$input] = $this->$input;
        }
        return $result;

    }

    public function all()
    {
        return $this->body;
    }

    public function __get($property)
    {
         if(isset($this->body[$property]))
             return $this->body[$property];

        if(isset($this->query[$property]))
            return $this->query[$property];

         if(isset($this->params[$property]))
             return $this->params[$property];
    }

    public function setParams($params)
    {
        $this->params = $params;
    }
}

