<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/14
 * Time: 16:31
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Controller;
use app\api\service\Token as TokenService;

class Order extends BaseController
{
    // 用户在选择商品后，向API提交包含它所选择商品的相关信息
    // API在接收到信息后，需要检查订单相关商品的库存量
    // 有库存，把订单数据存入数据库中= 下单成功了，返回客户端消息，告诉客户端可以支付了
    // 调用我们的支付接口，进行支付
    // 还需要再次进行库存量检测
    // 服务器这边就可以调用微信的支付接口进行支付
    // 小程序根据服务器返回的结果拉起微信支付
    // 微信会返回给我们一个支付的结果（异步）
    // 成功：也需要进行库存量的检查
    // 成功：进行库存量的扣除

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    /**
     * 下单
     */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');  //获取数组
        $uid = TokenService::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    // 做一次库存量检测
    // 创建订单
    // 减库存--预扣除库存
    // if pay 真正的减库存
    // 在一定时间内30min没有去支付这个订单，我们需要还原库存

    // 在PHP里写一个定时器，每隔1min去遍历数据库，找到那些超时的
    // 订单，把这些订单给还原库存
    // linux crontab

    // 任务队列
    // 订单任务加入到任务队列里
    // redis

    //定时器，每隔1s，5s，访问API的接口

//    //下单的前置方法
//    protected function checkExclusiveScope()
//    {
//        $scope = TokenService::getCurrentTokenVar('scope');
//        if ($scope) {
//            if ($scope >= ScopeEnum::User) {
//                return true;
//            } else {
//                throw new ForbiddenException();
//            }
//        } else {
//            throw new TokenException();
//        }
//    }

}