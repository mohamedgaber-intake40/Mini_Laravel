<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 11:51 AM
 */

use app\Controllers\HomeController;
use Core\Route;
use Core\Router;

Route::get('/',[HomeController::class,'index'])->name('home');





