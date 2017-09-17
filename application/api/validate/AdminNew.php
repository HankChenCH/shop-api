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
		'password' => 'isNotEmpty|min:6|max:14',
		'repassword' => 'isNotEmpty|isEqualPassword',
		'true_name' => 'require|isNotEmpty',
		'state' => 'require|number|between:0,1',
	];

	protected $scene = [
        'create' => ['user_name','password','repassword','true_name'],
        'update' => ['password','repassword','true_name'],
        'updateStatus' => ['state'],
	];

	protected function isEqualPassword($value, $rule='', $data='', $field='')
	{
		if ($data['password'] === $value) {
			return true;
		}

		return false;
	}
}