<?php

namespace app\api\validate;

class CountMonthInt extends BaseValidate
{
	protected $rule = [
		'countMonth' => 'require|number|between:1,12'
	];
}