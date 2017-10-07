<?php

namespace app\api\validate;

class BuyNow extends BaseValidate
{
	protected $rules = [
		'batch_no' => 'required|isNotEmpty',
		'start_time' => 'required|isNotEmpty',
		'end_time' => 'required|isNotEmpty',
		'price' => 'required|isNotEmpty',
		'stock' => 'required|isNotEmpty|number',
		'limit_every' => 'required|isNotEmpty|number',
		'rules' => 'required|isNotEmpty',
	];

	protected $scene = [
		'create' => ['batch_no', 'start_time', 'end_time', 'price', 'stock', 'limit_every', 'rules']
	];
}