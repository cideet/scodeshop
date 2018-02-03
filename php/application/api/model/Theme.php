<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/2
 * Time: 17:11
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['head_img_id', 'topic_img_id', 'delete_time', 'update_time'];

    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');  //一对一
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');  //一对一
    }
}