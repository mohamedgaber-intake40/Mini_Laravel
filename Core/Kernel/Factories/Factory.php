<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 10/10/2020
 * Time: 01:27 م
 */

namespace Core\Kernel\Factories;


class Factory
{
    private $role_model;
    private $factories_directory = '/Core/Kernel/Factories/';
    private $role_models_directory = '/Core/Kernel/RoleModels/';
    private $destination;
    private $destination_directory;
    private $type;


    public function __construct($name,$type)
    {
        $this->type = ucfirst($type) ;
        $type_plural = $this->type . 's';
        $role_model_file_name = $this->type . "RoleModel.php";

        $this->role_model = ROOT_DIR .$this->role_models_directory. $role_model_file_name;
        $this->destination_directory = ROOT_DIR . "/app/$type_plural/";


        $this->destination =  $this->destination_directory . "$name.php";
        $this->factories_directory = ROOT_DIR . $this->factories_directory ;

        if($this->checkFileExists())
        {
            echo "$this->type Already Exists";
            return;
        }
        $this->create($name);
    }
    private function create($name)
    {
        copy($this->role_model,$this->destination);

        $content =  file_get_contents($this->destination);
        $content = str_replace($this->type."RoleModel","$name",$content);

        $file = fopen($this->destination,'w');
        fwrite($file,$content);
        fclose($file);
        echo "$this->type Created Successfully";
    }

    private function checkFileExists()
    {
        return file_exists($this->destination);
    }
}
