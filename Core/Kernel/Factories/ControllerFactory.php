<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 08/10/2020
 * Time: 04:42 م
 */

namespace Core\Kernel\Factories;


class ControllerFactory extends Factory
{

    public function __construct($name)
    {
        parent::__construct();
        $this->type = 'Controller';
        $this->destination_directory =  '/app/Controllers/';
        $this->role_model =  $this->role_models_directory . "ControllerRoleModel.php";
        $this->make($name);
    }

}
