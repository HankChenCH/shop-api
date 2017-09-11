<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 22:26
 */

namespace app\api\model;



class Admin extends BaseModel
{
    protected $hidden = ['password','update_time','delete_time'];

    public static function login($loginName, $password)
    {
        $admin = self::where('user_name', '=', $loginName)
                    ->where('password', '=', md5($password))
                    ->find();

        return $admin;
    }
}