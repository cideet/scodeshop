<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/5
 * Time: 21:51
 */

namespace app\api\service;

class Token
{
    //生成令牌
    public static function generateToken()
    {
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];  //获取时间戳
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

}