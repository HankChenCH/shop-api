<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:24
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\excetion\ParameterExcetion;

class Token
{
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }

    public function validateToken($token="")
    {
        if (!$token) {
            throw new ParameterExcetion([
                'msg' => 'token不允许为空'
            ]);
        }

        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

    public function getAdminToken()
    {
        header("Access-Control-Allow-Origin: *"); 
    	$token = UserToken::generateToken();
    	return [
    		'data' => [
    			'token' => $token,
    			'exprie_in' => time() + 7200 
    		]
    	];
    }
}