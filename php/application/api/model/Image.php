<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/30
 * Time: 0:19
 */

namespace app\api\model;

use think\Model;

class Image extends Model
{
    protected $hidden = ['delete_time', 'update_time'];

}