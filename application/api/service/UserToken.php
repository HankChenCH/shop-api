<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\User as UserModel;
use app\lib\exception\WxException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;
use app\lib\enum\UserTypeEnum;

class UserToken extends Token implements GrantToken
{
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;
    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if (empty($wxResult)){
            throw new \Exception('获取openid异常，微信内部错误');
        }
        else{
            if (array_key_exists('errcode',$wxResult)){
                $this->processLoginError($wxResult);
            }else{
                $tokenType = config('setting.token_type');
                $method = 'grant' . $tokenType;
                if (method_exists($this, $method)) {
                    return $this->$method($wxResult);
                } else {
                    throw new \Exception();
                }
            }
        }
    }

    public function grantJWT($wxResult)
    {
        $uid = $this->grantUid($wxResult);

        $userInfo = $this->prepareUserInfo($wxResult, $uid);
        return self::generateJWT($userInfo);
    }

    public function grantCache($wxResult)
    {
        $uid = $this->grantUid($wxResult);

        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        return $this->saveToCache($cacheValue);
    }

    private function prepareUserInfo($wxResult,$uid)
    {
        $info['iss'] = "https://zsshitan.com";
        $info['aud'] = UserTypeEnum::Weapp;
        $info['iat'] = time() - 1000;
        $info['nbf'] = time();
        $info['exp'] = time() + config('setting.token_expire_in');
	    $info['user'] = $wxResult;
        $info['user']['uid'] = $uid;
        $info['user']['ip'] = getClientIp();
        $info['user']['scope'] = ScopeEnum::User;

        return $info;
    }

    private function prepareCacheValue($wxResult,$uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
    }

    private function grantUid($wxResult)
    {
        $user = UserModel::getByOpenID($wxResult['openid']);

        if ($user) {
            $uid = $user->id;
        }
        else{
            $uid = $this->newUser($wxResult['openid']);
        }

        return $uid;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
                'openid' => $openid
            ]);
        return $user->id;
    }

    private function processLoginError($wxResult)
    {
        throw new WxException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}
