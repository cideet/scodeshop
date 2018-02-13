<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/13
 * Time: 23:49
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}