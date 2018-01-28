<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 19:39
 */

namespace app\api\validate;

class BaseValidate extends \think\Validate
{
    public function goCheck()
    {
        $request = \think\Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if (!$result) {
            $error = $this->error;
            throw new \think\Exception($error);
        } else {
            return true;
        }
    }
}