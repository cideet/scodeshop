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
}