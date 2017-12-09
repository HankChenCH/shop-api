<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 22:26
 */

namespace app\api\model;

use think\Request;
use app\lib\exception\AdminException;

class Admin extends BaseModel
{
    protected $hidden = ['password','update_time','delete_time'];

    public function profile()
    {
    	return $this->hasOne('AdminProfile','admin_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Role', 'AdminRole', 'role_id', 'admin_id');
    }

    public static function login($loginName, $password)
    {
        $admin = self::get([
                    'user_name' => $loginName,
                    'password' => md5($password),
                    'state' => '1'
                ],['roles','roles.resources']);

        if (!$admin) {
            throw new AdminException([
                'msg' => '登录错误, 用户名不存在或密码错误!'
            ]);
        }

        $admin->save(['login_time'=>time(), 'login_ip'=>ip2long(getClientIP())]);

        return $admin;
    }
}
