<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 22:26
 */

namespace app\api\model;



class Banner extends BaseModel
{
    protected $hidden = ['id','update_time','delete_time'];
	public function items()
	{
		return $this->hasMany('BannerItem','banner_id','id');
	}

    public static function getBannerById($id)
    {
         $banner = self::with(['items','items.img'])
         	->find($id);

        return $banner;
    }
}