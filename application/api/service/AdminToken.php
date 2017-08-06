<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\lib\exception\AdminException;
use app\lib\enum\ScopeEnum;

class AdminToken extends Token
{
	public function get($admin)
    {

        if ($admin) {
            $uid = $admin['id'];
        }
        else{
            throw new AdminException([
            	'msg' => '登录错误, 用户名不存在或密码错误!'
            ]);
        }

        $cacheValue = $this->prepareCacheValue($uid);
        return $this->saveToCache($cacheValue);
    }

    private function prepareCacheValue($uid)
    {
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::Super;
        return $cacheValue;
    }
}