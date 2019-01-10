<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 21:12
 */

namespace app\api\model;

class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }
    
    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)->find();
        return $user;
    }


}