<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;


use app\api\validate\IDConllection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    public function getSimpleList($ids='')
    {
        (new IDConllection())->goCheck();

        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);

        if ($result->isEmpty()){
            throw new ThemeException();
        }

        return $result;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $result = ThemeModel::getThemeWithProducts($id);

        if (!$result){
            throw new ThemeException();
        }

        return $result;
    }
}