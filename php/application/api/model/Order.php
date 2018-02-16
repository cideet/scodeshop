<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/16
 * Time: 10:30
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
}