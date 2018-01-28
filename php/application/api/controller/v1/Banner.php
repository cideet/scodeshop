<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 18:34
 */

namespace app\api\controller\v1;

use app\api\validate\TestValidate;

class Banner
{
    /**
     * 获取指定ID的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner ID号
     */
    public function getBanner($id)
    {

        $data = [
            'name' => 'vendor12345',
            'email' => 'zhangsfqq.com'
        ];
//        $validate = new \think\Validate([  //独立验证
//            'name' => 'require|max:10',
//            'email' => 'email'
//        ]);
        $validate = new TestValidate();  //验证码
        $validate->batch()->check($data);
        var_dump($validate->getError());
    }
}