<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 8:53
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected function imgPrefix($value,$data)
    {
        $finUrl = $value;
        if($data['from'] == 1){
            $finUrl = config('setting.img_prefix') . $value;
        }
        return $finUrl;
    }
}