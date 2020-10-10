<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 08/10/2020
 * Time: 04:42 م
 */

namespace Core\Kernel\Factories;


class ControllerFactory
{
    private $dir ;
    private $role_model;
    private $controllers_directory = '/app/Controllers/';
    private $factories_directory = '/Core/Kernel/Factories/';
    private $role_models_directory = '/Core/Kernel/RoleModels/';
    private $destination;


    public function __construct($controller_name)
    {
        $this->dir =str_replace('\\', '/', __DIR__);

        $this->role_model = ROOT_DIR . $this->role_models_directory . 'ControllerRoleModel.php';
        $this->controllers_directory = ROOT_DIR . $this->controllers_directory ;
        $this->destination =  $this->controllers_directory . "$controller_name.php";
        $this->factories_directory = ROOT_DIR . $this->factories_directory ;

        if($this->checkFileExists())
        {
            echo "Controller Already Exists";
            return;
        }
        $this->create($controller_name);
    }
    private function create($controller_name)
    {
        copy($this->role_model,$this->destination);

        $content =  file_get_contents($this->destination);
        $content = str_replace('ControllerRoleModel',"$controller_name",$content);

        $file = fopen($this->destination,'w');
        fwrite($file,$content);
        fclose($file);
        echo 'Controller Created Successfully';
    }

    private function checkFileExists()
    {
        return file_exists($this->destination);
    }


}
