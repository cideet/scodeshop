<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 19:39
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;

class BaseValidate extends \think\Validate
{
    public function goCheck()
    {
        $request = Request::instance();  //获取http传入的参数
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
                //'code' => 400,
                //'errorCode' => 10002
            ]);
            throw $e;
        } else {
            return true;
        }
    }
}