<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/10
 * Time: 6:34
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    //创建或更新地址
    public function createOrUpdateAddress()
    {
        (new AddressNew())->goCheck();
        $uid = TokenService::getCurrentUid();  //根据Token获取UID
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $dataArray = getDatas();
        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save($dataArray);  //新增，模型的关联
        } else {
            $user->address->save($dataArray);  //更新
        }
        //return $user;
        return new SuccessMessage();
    }
}