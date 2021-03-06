<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'mobile' => 'require',
		'province' => 'require|isNotEmpty',
		'city' => 'require|isNotEmpty',
		'country' => 'require|isNotEmpty',
		'detail' => 'require|isNotEmpty'
	];

	protected $scene = [
        'createAndUpdate' => ['name','mobile','province','city','country','detail']
	];
}