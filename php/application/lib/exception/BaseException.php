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

    public function __construct($param = [])
    {
        if (!is_array($param)) {
            return;
            // throw new Exception('参数必须是数组');
        }
        if (array_key_exists('code', $param)) {
            $this->code = $param['code'];
        }
        if (array_key_exists('msg', $param)) {
            $this->msg = $param['msg'];
        }
        if (array_key_exists('errorcode', $param)) {
            $this->errorcode = $param['errorcode'];
        }
    }
}