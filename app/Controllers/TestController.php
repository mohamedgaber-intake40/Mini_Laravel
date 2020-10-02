<?php


namespace app\Controllers;


class TestController extends Controller
{
    public function show()
    {
        $data = [
            'name' => 'mohamed',
            'age' => '25'
        ];

        $this->render('users.test' , compact('data'));
    }

    public function showAvatar()
    {
        $this->render('users.avatar');
    }
}
