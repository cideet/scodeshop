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
    public $msg = 'invalid parameters';
    public $errorCode = 10000;
}