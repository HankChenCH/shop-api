<?php

namespace app\api\validate;

use app\lib\exception\ProductException;

class OrderStatus extends BaseValidate
{
	protected $rule = [
		'status' => 'require|number|between:1,5',
	];
}