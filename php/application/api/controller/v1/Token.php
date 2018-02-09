<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 21:00
 */

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    /**
     * 获取Token
     * @param string $code
     * @return array
     */
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }
}