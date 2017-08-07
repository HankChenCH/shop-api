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
		'summary' => 'require|isNotEmpty',
		'from' => 'require|isPostiveInteger',
		'img_id' => 'require|number',
		'main_img_url' => 'require|isNotEmpty',
		'price' => 'require|number',
		'stock' => 'require|isPostiveInteger',
		'is_on' => 'require',
	];

	protected $scene = [
		'baseCreate' => ['name','summary','from','price','stock','main_img_url','img_id','is_on'],
        'updateStockAndPrice' => ['price','stock'],
        'pullOnOff' => ['is_on'],
	];
}