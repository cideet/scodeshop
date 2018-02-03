<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/2
 * Time: 17:06
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    /**
     * @url /theme?id=id1,id2,id3
     * 获取所有专题
     */
    public function getSimpleList($ids = '')
    {
        $validate = new IDCollection();
        $validate->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if ($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }

    /**
     * @url /theme/:id
     * 获取单个专题
     */
    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if ($theme->isEmpty()) {
            throw new ThemeException();
        }
        return $theme;
    }
}