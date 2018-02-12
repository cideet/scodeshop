<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/12
 * Time: 3:42
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}