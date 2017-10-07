<?php

namespace app\api\validate;

class ExpressInfo extends BaseValidate
{
	protected $rules = [
		'express_name' => 'required|isNotEmpty',
		'express_price' => 'required|isNotEmpty',
		'express_limit' => 'required|isNotEmpty',
	];

	protected $scene = [
		'create' => ['express_name', 'express_price', 'express_limit'],
		'update' => ['express_name', 'express_price', 'express_limit'],
	];
}