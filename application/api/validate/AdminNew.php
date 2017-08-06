<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class AdminNew extends BaseValidate
{
	protected $rule = [
		'user_name' => 'require|isNotEmpty',
		'password' => 'require|isNotEmpty|min:6',
		'repassword' => 'require|isNotEmpty|isEqualPassword',
		'true_name' => 'require|isNotEmpty',
	];

	protected $scene = [
        'create' => ['user_name','password','repassword','true_name']
	];

	protected function isEqualPassword($value, $rule='', $data='', $field='')
	{
		if ($data['password'] === $value) {
			return true;
		}

		return false;
	}
}