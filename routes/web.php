<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 9/3/2020
 * Time: 11:51 AM
 */

use Core\Route;
use Core\Router;

Route::get('/','HomeController@index')->name('home');

Route::get('register','AuthController@show')->name('register');
Route::post('register','AuthController@register');
Route::post('login','AuthController@login');


Route::get('countries','CountryController@index')->name('countries.index');

Route::get('users/export','UserController@export');

Route::get('test','TestController@show')->name('test.show');
Route::get('avatar','TestController@showAvatar')->name('avatar');
Route::get('users/create','UserController@create')->name('users.create');
Route::post('users','UserController@store')->name('users.store');



