<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/5
 * Time: 22:07
 */

namespace app\lib\exception;

class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}