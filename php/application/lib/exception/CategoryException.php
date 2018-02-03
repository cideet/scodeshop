<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 20:07
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode = 50000;
}