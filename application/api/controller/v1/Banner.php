<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\exception\BannerMissException;

class Banner
{
    public function getBanner($id)
    {
        $validate = new IDMustBePostiveInt();
        $validate->goCheck();

        $bannerList = BannerModel::getBannerById($id);

        if (!$bannerList){
            throw new BannerMissException();
        }
        return $bannerList;
    }
}