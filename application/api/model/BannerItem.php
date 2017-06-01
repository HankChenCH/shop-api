<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 22:26
 */

namespace app\api\model;



class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];

    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}