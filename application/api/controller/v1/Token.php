<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:24
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

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