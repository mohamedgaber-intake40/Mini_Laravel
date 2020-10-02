<?php

namespace app\Controllers;
use Core\Request;

/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 12:24 PM
 */

class HomeController extends Controller
{
    public function index()
    {
        redirect(route('users.create'));
    }

}
