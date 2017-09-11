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
		'total_price' => 'require|number',
		'reason' => 'require|isNotEmpty'
	];

	protected $scene = [
        'changePrice' => ['total_price','reason'],
	];
}