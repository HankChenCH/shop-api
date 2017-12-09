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
use \Firebase\JWT\JWT;

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
		$tokenType = config('setting.token_type');
		$method = 'get' . $tokenType . 'Var';
		
		if (method_exists(__CLASS__, $method)) {
			return static::$method($token, $key);
		} else {
			throw new \Exception();
		}
	}

	protected static function getCacheVar($token, $key)
	{
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

	protected static function getJWTVar($token, $key)
	{
		$vars = static::decodedJWT($token);

		if (!$vars) {
			throw new TokenException();
		}else{
			if (!is_object($vars)) {
				$vars = json_decode($vars,true);
			}

			if (isset($vars->user->$key)) {
				return $vars->user->$key;
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
		$tokenType = config('setting.token_type');
		if ($tokenType === 'cache') {
			$vars = Cache::pull($token);
		} else {
			$vars = static::decodedJWT($token);
		}
		return $vars;
	}

	public static function generateJWT($info)
	{
		$jwt = JWT::encode($info, md5(config('secure.token_salt') . getClientIp()));
		if (!$jwt) {
			throw new TokenException([
                'msg' => '令牌初始化失败',
                'errorCode' => 10001
            ]);
		}

		return $jwt;
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

    public static function needAdminScope()
    {
    	return self::checkScope('==',ScopeEnum::Super);
    }

	public static function needPrimaryScope()
	{
		return self::checkScope('>=',ScopeEnum::User);
	}

	public static function needExclusiveScope()
	{
		return self::checkScope('==',ScopeEnum::User);
	}

	private static function checkScope($op,$scopeType)
	{
		$scope = self::getCurrentTokenVar('scope');

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

	public static function verifyJWT($jwt)
	{
		return (bool)static::decodedJWT($jwt);
	}

	public static function decodedJWT($jwt)
	{
		try{
            $decoded = JWT::decode($jwt, md5(config('secure.token_salt') . getClientIp()), array('HS256'));
            
            return $decoded;
        } catch (\Exception $e) {
        	// var_dump($e->getMessage());
            return false;
        }
	}
}
