<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/10
 * Time: 6:34
 */

namespace app\api\controller\v1;
use app\api\service\Token as TokenService;

use app\api\validate\AddressNew;

class Address
{
    public function createOrUpdateAddress()
    {
        (new AddressNew())->goCheck();
        $uid = TokenService::getCurrentUid();
    }
}