<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/22
 * Time: 21:12
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不能为空');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        $this->checkOrderValid();  //订单号检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);  //库存量检测
        if (!$status['pass']) {
            return $status;
        }
    }

    private function makeWxProOrder(){}

    //订单号检测
    private function checkOrderValid()
    {
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if (!$order) {
            throw new OrderException();  //第1步：验证订单号是否存在
        }
        if (!Token::isValidOperate($order->user_id)) {
            //第2步：验证订单号和当前用户是否匹配
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            //第3步：验证订单是否已支付
            throw new OrderException([
                'msg' => '订单已支付过啦',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}