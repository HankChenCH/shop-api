<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class WxInfo extends BaseValidate
{
	protected $rule = [
		'extend' => 'require',
		'nickname' => 'require'
	];

	protected $scene = [
		'updateInfo' => ['extend','nickname']
	];
}