<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:29
 */

namespace app\api\model;


class User extends BaseModel
{
    protected $hidden = ['create_time','update_time','delete_time','openid'];

    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }

    public function getExtendAttr($value)
    {
        return json_decode($value,true);
    }

    public function address()
    {
    	return $this->hasOne('UserAddress','user_id','id');
    }
}