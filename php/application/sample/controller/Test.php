<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 16:16
 */

namespace app\sample\controller;

class Test
{
    public function hello($id, $name)
    {
        echo($id . '|' . $name);
        return 'hello world !';
    }

    public function hello2()
    {
        $id = \think\Request::instance()->param('id');
        $age = \think\Request::instance()->param('age');
        $name = \think\Request::instance()->param('name');
        echo($id . '|' . $name . '|' . $age);
        // $all = \think\Request::instance()->param();
        $all = input('param');
        print_r($all);
    }
}