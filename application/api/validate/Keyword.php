<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class Keyword extends BaseValidate
{
	protected $rule = [
		'keyword' => 'require|isNotEmpty'
	];

	protected $message = [
		'keyword' => '搜索词不能为空'
	];

	protected $scene = [
        'createAndUpdate' => ['keyword']
	];
}