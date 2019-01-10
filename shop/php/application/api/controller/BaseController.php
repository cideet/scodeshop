<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/14
 * Time: 19:13
 */

namespace app\api\controller;

use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    //需要用户和CMS管理员都可以访问的权限
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    //只有用户才能访问的接口权限
    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}