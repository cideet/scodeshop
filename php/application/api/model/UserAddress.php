<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/12
 * Time: 22:48
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}