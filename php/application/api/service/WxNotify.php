<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/24
 * Time: 15:09
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
//    <xml>
//    <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
//    <attach><![CDATA[支付测试]]></attach>
//    <bank_type><![CDATA[CFT]]></bank_type>
//    <fee_type><![CDATA[CNY]]></fee_type>
//    <is_subscribe><![CDATA[Y]]></is_subscribe>
//    <mch_id><![CDATA[10000100]]></mch_id>
//    <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
//    <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
//    <out_trade_no><![CDATA[1409811653]]></out_trade_no>
//    <result_code><![CDATA[SUCCESS]]></result_code>
//    <return_code><![CDATA[SUCCESS]]></return_code>
//    <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
//    <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
//    <time_end><![CDATA[20140903131540]]></time_end>
//    <total_fee>1</total_fee>
//    <trade_type><![CDATA[JSAPI]]></trade_type>
//    <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
//    </xml>

    //处理在支付过后，微信是否向服务器发送回调通知
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {  //支付是否成功
            $orderNo = $data['out_trade_no'];  //订单号
            Db::startTrans();  //事务
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)->lock(true)->find();  //查询订单 锁
                if ($order->status == 1) {  //订单没有被处理时
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);  //库存量检测
                    if ($stockStatus['pass']) {  //支付成功，并且库存量检测通过
                        $this->updateOrderStatus($order->id, true);  //更新订单状态
                        $this->reduceStock($stockStatus);  //减库存量
                    } else {  //库存量检测不成功
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();  //事务
                return true;
            } catch (Exception $ex) {
                Db::rollback();  //事务
                Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }

    //减库存量
    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            //$singlePStatus['counts'] 某一类商品的数量
            Product::where('id', '=', $singlePStatus['id'])->setDec('stock', $singlePStatus['counts']);
        }
    }

    //更新订单状态
    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)->update(['status' => $status]);
    }

}