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
    protected $role_model;
    private $factories_directory = '/Core/Kernel/Factories/';
    protected $role_models_directory = '/Core/Kernel/RoleModels/';
    protected $destination;
    protected $destination_directory;
    protected $type;


    public function __construct()
    {
        $this->factories_directory = ROOT_DIR . $this->factories_directory ;
    }
    protected function make($name)
    {
        $this->resolveFullPath();


        $this->destination = $this->destination_directory. "$name.php";

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

    private function resolveFullPath()
    {
        $this->destination_directory = ROOT_DIR . $this->destination_directory;
        $this->role_model = ROOT_DIR . $this->role_model;
    }

    private function checkFileExists()
    {
        return file_exists($this->destination);
    }
}
