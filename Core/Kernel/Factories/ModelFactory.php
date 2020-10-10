<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 08/10/2020
 * Time: 04:42 م
 */

namespace Core\Kernel\Factories;


class ModelFactory extends Factory
{

    public function __construct($name)
    {
        parent::__construct();
        $this->type = 'Model';
        $this->destination_directory =  '/app/Models/';
        $this->role_model =  $this->role_models_directory . "ModelRoleModel.php";
        $this->make($name);
    }

}
