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
use app\api\service\AdminToken;
use app\api\model\Admin as AdminModel;
use app\api\validate\TokenGet;
use app\api\validate\AdminLogin;
use app\lib\exception\ParameterExcetion;
use app\lib\exception\TokenException;
use \Firebase\JWT\JWT;

class Token
{
    public function getJwt()
    {
    	$key = config('secure.token_salt');
    	$token = array(
        		"iss" => "https://zsshitan.com",
        		"aud" => "weapp",
        		"iat" => time() - 1000,
        		"nbf" => time(),
    		    "exp" => time() + 7200,
    		    "user" => array(
    			"uid" => 2,
    			"name" => "hank",
    		)
    	);

    	/**
    	 * IMPORTANT:
    	 * You must specify supported algorithms for your application. See
    	 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
    	 * for a list of spec-compliant algorithms.
    	 */
    	$jwt = JWT::encode($token, $key);

    	return [
    		'jwt' => $jwt,
    	];
    }

    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->getJWT();
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

        // $valid = TokenService::verifyToken($token);
        $valid = TokenService::verifyJWT($token);
        return [
            'isValid' => $valid
        ];
    }

    public function getAdminToken()
    {
        (new AdminLogin())->goCheck();

        $data = input('post.');
        
        $admin = AdminModel::login($data['login_name'], $data['password']);

    	$at = new AdminToken();
        $token = $at->get($admin);
    	return [
			'token' => $token,
            'username' => $admin['true_name'],
			'exprie_in' => time() + 7200 
    	];
    }

    public function reAdminToken()
    {
        $uid = TokenService::getCurrentUid();

        $admin = AdminModel::find($uid);

        $at = new AdminToken();
        $token = $at->get($admin);

        return [
            'token' => $token,
            'username' => $admin['true_name'],
            'exprie_in' => time() + 7200 
        ];
    }

    public function logOnAdminToken()
    {
        $token = TokenService::removeCurrentToken();
        if (!$token) {
            throw new TokenException([
                'msg' => '用户注销失败'
            ]);
        }

        return $token;
    }
}
