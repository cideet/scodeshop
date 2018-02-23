<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/22
 * Time: 11:35
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getProOrder']
    ];

    //请求预订单的信息
    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }
}