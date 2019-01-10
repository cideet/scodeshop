<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 19:56
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'create_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}