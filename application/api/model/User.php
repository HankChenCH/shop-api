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
    protected $hidden = ['update_time','delete_time','openid'];

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

    // public static function getAllBySearch($nickname, $create_time)
    // {
    //     $users = new self;
        
    //     if (!empty($nickname)) {
    //         $users->where('nickname','like',"%{$nickname}%");
    //     }

    //     if (count($create_time) == 2) {

    //         if (!is_numeric($create_time[0])) {
    //             array_walk($create_time, function(&$v){
    //                 $v = strtotime($v);
    //             });
    //         }

    //         $users->where('create_time','between',$create_time);
    //     }

    //     $users->order('create_time desc');

    //     return $users;
    // }
}