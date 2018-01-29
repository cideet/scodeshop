<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/29
 * Time: 9:51
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}