<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 08/10/2020
 * Time: 04:42 م
 */

namespace Core\Kernel\Factories;


class ModelFactory
{
    private $role_model;
    private $models_directory = '/app/Models/';
    private $factories_directory = '/Core/Kernel/Factories/';
    private $role_models_directory = '/Core/Kernel/RoleModels/';
    private $destination;


    public function __construct($model_name)
    {
        $this->role_model = ROOT_DIR . $this->role_models_directory . 'ModelRoleModel.php';
        $this->models_directory = ROOT_DIR . $this->models_directory ;
        $this->destination =  $this->models_directory . "$model_name.php";
        $this->factories_directory = ROOT_DIR . $this->factories_directory ;

        if($this->checkFileExists())
        {
            echo "Model Already Exists";
            return;
        }
        $this->create($model_name);
    }
    private function create($model_name)
    {
        copy($this->role_model,$this->destination);

        $content =  file_get_contents($this->destination);
        $content = str_replace('ModelRoleModel',"$model_name",$content);

        $file = fopen($this->destination,'w');
        fwrite($file,$content);
        fclose($file);
        echo 'Model Created Successfully';
    }

    private function checkFileExists()
    {
        return file_exists($this->destination);
    }


}
