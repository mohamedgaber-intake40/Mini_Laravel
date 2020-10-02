<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 30/09/2020
 * Time: 09:28 ص
 */

namespace app\Controllers;


use app\Models\User;
use Core\Request;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $this->validate($request);


        $user_id = User::create($request->only('name','email','hospital','country_id'));
        if(!$user_id)
        {
            echo json_response(['message' => 'Failed to save user'],500);
            exit();
        }


        echo json_response([
            'message' => 'user saved successfully',
            'redirect' => $redirect
        ],200);
    }

    private function validate(Request $request)
    {
        $request->validate('Name',$request->name,'required|alphaSpace|min:2|max:255');
        $request->validate('Email',$request->email,'required|email|max:255|unique:users,email');
        $request->validate('Hospital',$request->hospital,'required|string|min:2|max:255');
        $request->validate('Country',$request->country_id,'required|number');
        $request->validate('Country',$request->country_id,'exists:countries,country_id');
    }

    public function login(Request $request)
    {
        $request->validate('Email',$request->email,'required|email|max:255');
        $request->validate('Password',$request->password,'required|string|max:255');


        $user = User::where(['email' => $request->email])[0];

        if(!$user)
        {
            return json_response(['message' => 'user not found'],404);
        }

        $valid = password_verify($request->password , $user->password);
        if(!$valid)
        {
            return json_response(['message' => 'invalid credentials'],403);
        }

        echo json_response([
            'message' => 'user found',
        ]);

    }


}
