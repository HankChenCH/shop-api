<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class OrderUpdate extends BaseValidate
{
	protected $rule = [
		'discount_price' => 'require|number',
		'reason' => 'require|isNotEmpty',
		'express_name' => 'require|isNotEmpty',
		'express_no' => 'require|isNotEmpty',
	];

	protected $scene = [
        'changePrice' => ['discount_price','reason'],
		'delivery' => ['express_name','express_no'],
	];
}