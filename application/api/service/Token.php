<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use think\Cache;
use think\Request;
use think\Exception;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;

class Token
{
	public static function generateToken()
	{
		$randChars = getRandChars(32);
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		$salt = config('secure.token_salt');

		$tokenArr = [$randChars,$timestamp,$salt];
		sort($tokenArr);
		$token = implode('', $tokenArr);

		return md5($token);
	}

	public static function getCurrentTokenVar($key)
	{
		$token = Request::instance()
			->header('token');
		$vars = Cache::get($token);

		if (!$vars) {
			throw new TokenException();
		}else{
			if (!is_array($vars)) {
				$vars = json_decode($vars,true);
			}

			if (array_key_exists($key, $vars)) {
				return $vars[$key];
			}else{
				throw new Exception("尝试获取的token变量并不存在");
			}
		}
	}

	public static function getCurrentNickName()
	{
		$nickName = self::getCurrentTokenVar('nickname');
		return $nickName;
	}

	public static function getCurrentUid()
	{
		$uid = self::getCurrentTokenVar('uid');
		return $uid;
	}

	public static function removeCurrentToken()
	{
		$token = Request::instance()
			->header('token');
		$vars = Cache::pull($token);
		return $vars;
	}

	public static function isValidOperate($checkUID)
    {
        if (!$checkUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }

        $currentOperateUID = self::getCurrentUid();
        if ($checkUID === $currentOperateUID){
            return true;
        }

        return false;
    }

    protected function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $result = cache($key,$value,$expire_in);
        if (!$result) {
            throw new TokenException([
                    'msg' => '服务器缓存异常',
                    'errorCode' => 10005
                ]);
        }

        return $key;
    }

	public static function needPrimaryScope()
	{
		return self::checkScope('>=',ScopeEnum::User);
	}

	public static function needExclusiveScope()
	{
		return self::checkScope('==',ScopeEnum::User);
	}

	private static function checkScope($op='==',$scopeType)
	{
		$scope = self::getCurrentTokenVar('scope');

		if (!$scope) {
			throw new TokenException();
		}

		switch ($op) {
			case '==':
				if ($scope == $scopeType) {
					return true;
				}
				break;
			case '>=':
				if ($scope >= $scopeType) {
					return true;
				}
				break;
			default:
				break;
		}

		throw new ForbiddenException();
	}

	public static function verifyToken($token)
	{
		$exisit = Cache::get($token);
		if ($exisit) {
			return true;
		}else{
			return false;
		}
	}
}