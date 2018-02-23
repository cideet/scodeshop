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
use think\Loader;
use think\Log;

//extend/WxPay/WxPay.Api.php
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

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
        return $this->makeWxProOrder($status['orderPrice']);
    }

    private function makeWxProOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');  //获取用户的微信openID
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);  //设置商户系统内部的订单号
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);  //设置订单总金额，微信以分为单位
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));  //用于接收微信回调地址
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        //prepay_id
//        $this->recordPreOrder($wxOrder);
//        $signature = $this->sign($wxOrder);
//        return $signature;
        return '';
    }

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