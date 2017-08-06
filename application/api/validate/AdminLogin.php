<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class AdminLogin extends BaseValidate
{
	protected $rule = [
		'login_name' => 'require|isNotEmpty',
		'password' => 'require|isNotEmpty',
	];
}