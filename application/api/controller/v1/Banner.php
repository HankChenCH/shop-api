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
use app\api\model\Resource as ResourceModel;
use app\exception\BannerMissException;

class Banner
{
    public function getBanner($id)
    {
	$request=  \think\Request::instance();
        
	$routeInfo = $request->routeInfo();
	$rule = array_splice($routeInfo['rule'], 2);

	$permission = strtoupper($routeInfo['option']['method']) . ' /' . implode('/', $rule);
	//return $permission;
	
	$resource = ResourceModel::where('description', $permission)->find();

	return $resource;
	
        //$validate = new IDMustBePostiveInt();
        //$validate->goCheck();

        //$bannerList = BannerModel::getBannerById($id);

        //if (!$bannerList){
            //throw new BannerMissException();
        //}
        //return $bannerList;
    }
}
