<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/22
 * Time: 11:35
 */

namespace app\api\controller;

use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getProOrder']
    ];

    //请求预订单的信息
    public function getPreOrder()
    {
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }
}