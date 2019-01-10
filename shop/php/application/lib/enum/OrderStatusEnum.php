<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/23
 * Time: 1:41
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID = 1;  // 待支付
    const PAID = 2;  // 已支付
    const DELIVERED = 3;  // 已发货
    const PAID_BUT_OUT_OF = 4;  // 已支付，但库存不足
}