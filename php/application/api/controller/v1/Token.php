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
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

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
        return ['token' => $token];
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
//    public function getAppToken($ac='', $se='')
//    {
//        (new AppTokenGet())->goCheck();
//        $app = new AppToken();
//        $token = $app->get($ac, $se);
//        return [
//            'token' => $token
//        ];
//    }

    /**
     * 验证Token
     * @param string $token
     * @return array
     * @throws ParameterException
     */
    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return ['isValid' => $valid];
    }
}