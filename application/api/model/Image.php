<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 8:40
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['id','from','delete_time','update_time'];

    public function getUrlAttr($value, $data)
    {
        return $this->imgPrefix($value, $data);
    }
}