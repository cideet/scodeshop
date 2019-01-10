<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 18:55
 */

namespace app\api\validate;


class TestValidate extends \think\Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email'
    ];
}