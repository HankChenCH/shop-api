<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class ProductParameter extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'main_img_url' => 'require',
		'price' => 'require|number',
		'stock' => 'require|isPostiveInteger',
		'is_on' => 'require',
	];

	protected $scene = [
        'updateStockAndPrice' => ['price','stock'],
        'pullOnOff' => ['is_on'],
	];
}