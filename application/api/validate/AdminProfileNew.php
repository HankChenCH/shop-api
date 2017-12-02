<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class AdminProfileNew extends BaseValidate
{
	protected $rule = [
		'phone' => 'isNotEmpty|min:11|max:11',
		'email' => 'isNotEmpty',
		'gender' => 'isNotEmpty',
		'age' => 'require|isPostiveInteger',
	];

	protected $scene = [
        'create' => ['phone','email','gender','age'],
        'update' => ['phone','email','gender','age'],
	];
}
