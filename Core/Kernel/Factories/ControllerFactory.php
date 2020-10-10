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
    private $role_model;
    private $controllers_directory = '/app/Controllers/';
    private $factories_directory = '/Core/Kernel/Factories/';
    private $role_models_directory = '/Core/Kernel/RoleModels/';
    private $destination;

    public function __construct($name, $type)
    {
        parent::__construct($name, $type);
    }


}
