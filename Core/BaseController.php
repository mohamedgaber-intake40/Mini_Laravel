<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 3:06 PM
 */
namespace Core;
class BaseController
{
    private $vars= [];
    private $views_name_space =  ROOT . 'views/';

    private function set ($data)
    {
        $this-> vars = array_merge($data ,$this->vars) ;
    }

    public function render($view_file, $data = [])
    {
        $this->set($data);
        extract($this->vars);
        $path_arr = explode('.',$view_file);
        $file_path = implode('/',$path_arr);
        $full_path = $this->views_name_space . $file_path . '.php';
        return require ($full_path);
    }
}
