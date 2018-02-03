<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 19:56
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    /**
     * 获取全部分类
     * @url /category/all
     * @http GET
     * @id banner ID号
     */
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');
        //$categories = CategoryModel::with(['img'])->select();
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}