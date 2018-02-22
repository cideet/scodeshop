<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/5
 * Time: 21:51
 */

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //生成Token
    public static function generateToken()
    {
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];  //获取时间戳
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

    //获取Token
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取Token变量不存在');
            }
        }
    }

    //根据Token获取UID
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    //需要用户和CMS管理员都可以访问的权限
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    // 只有用户才能访问的接口权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /**
     * //是否是一个合法的操作
     * @param $checkedUID //被检测的UID
     */
    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new Exception('检查UID时，必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }


}