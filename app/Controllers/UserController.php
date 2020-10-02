<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 30/09/2020
 * Time: 03:47 م
 */

namespace app\Controllers;

use app\Models\User;
use Core\Excel\ExcelExporter;
use Core\Request;

class UserController extends Controller
{
    public function create()
    {
        $this->render('users.create');
    }

    public function store(Request $request)
    {

        $request->validate('Name',$request->name,'required|max:255|min:5');
        $request->validate('Email',$request->email,'required|email|max:255|min:50');
        $request->validate('age',$request->name,'required|number');
        var_dump($request->only('name','age'));
        var_dump($request->body);
    }

    public function export()
    {
        $users = User::query()
                ->join('countries','users.id','countries.id')
                ->select('users.name','users.email','users.hospital','countries.name as country_name')
                ->get();

         ExcelExporter::create($users)
                ->setColumns([ 'A' , 'B' , 'C' , 'D' ])
                ->setColumnsHead([ 'User name' , 'Email' , 'Hospital' , 'Country' ])
                ->setColumnWidth([ 35 , 35 , 50 , 30 ])
                ->setFileName('users')
                ->export([
                    'A'=>'name',
                    'B'=>'email',
                    'C'=>'hospital',
                    'D'=>'country_name',
                ]);
    }
}
