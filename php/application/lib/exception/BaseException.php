<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 20:58
 */

namespace app\lib\exception;
use think\Exception;

class BaseException extends Exception
{
    public $code = 400;  //HTTP状态码（404，200）
    public $msg = '参数错误';  //错误具体信息
    public $errorcode = 10000;  //自定义错误码
}