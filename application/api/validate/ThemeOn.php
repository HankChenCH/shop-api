<?php

namespace app\api\validate;

class ThemeOn extends BaseValidate
{
	protected $rule = [
		'is_on' => 'require',
	];
}