<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 19:15
 */

namespace app\api\validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'ID必须是正整数'
    ];

}