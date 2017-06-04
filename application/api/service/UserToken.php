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

class UserToken extends Token
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
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult)
    {
        $user = UserModel::getByOpenID($wxResult['openid']);

        if ($user) {
            $uid = $user->id;
        }
        else{
            $uid = $this->newUser($wxResult['openid']);
        }

        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        return $this->saveToCache($cacheValue);
    }

    private function saveToCache($cacheValue)
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

    private function prepareCacheValue($wxResult,$uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
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