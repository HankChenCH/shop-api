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
        if (!$admin) {
            throw new AdminException([
            	'msg' => '登录错误, 用户名不存在或密码错误!'
            ]);
        }

        $cacheValue = $this->prepareCacheValue($admin);
        return $this->saveToCache($cacheValue);
    }

    private function prepareCacheValue($adminUser)
    {
        $cacheValue['uid'] = $adminUser['id'];
        $cacheValue['username'] = $adminUser['user_name'];
        $cacheValue['nickname'] = $adminUser['true_name'];
        $cacheValue['scope'] = ScopeEnum::Super;
        return $cacheValue;
    }
}