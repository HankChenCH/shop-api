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

class AdminToken extends Token implements GrantToken
{
	public function get($admin)
    {
        if (!$admin) {
            throw new AdminException([
            	'msg' => '登录错误, 用户名不存在或密码错误!'
            ]);
        }

        $tokenType = config('setting.token_type');
        $method = 'grant' . $tokenType;
        if (method_exists($this, $method)) {
            return $this->$method($admin);
        } else {
            throw new \Exception();
        }
    }

    public function grantJWT($admin)
    {
        $info = $this->prepareUserInfo($admin);
        return self::generateJWT($info);
    }

    private function prepareUserInfo($admin)
    {
        $info['iss'] = "https://zsshitan.com";
        $info['aud'] = "manager";
        $info['iat'] = time() - 1000;
        $info['nbf'] = time();
        $info['exp'] = time() + config('setting.token_expire_in');
        $info['user'] = [
            "uid" => $admin['id'],
            "username" => $admin['true_name'],
            "nickname" => $admin['true_name'],
            "scope" => ScopeEnum::Super
        ];

        return $info;
    }

    public function grantCache($admin)
    {
        $cacheValue = $this->prepareCacheValue($admin);
        return $this->saveToCache($cacheValue);
    }

    private function prepareCacheValue($admin)
    {
        $cacheValue['uid'] = $admin['id'];
        $cacheValue['username'] = $admin['user_name'];
        $cacheValue['nickname'] = $admin['true_name'];
        $cacheValue['scope'] = ScopeEnum::Super;
        return $cacheValue;
    }
}
