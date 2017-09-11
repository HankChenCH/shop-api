<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


class ThemeNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'description' => 'require|isNotEmpty',
		'head_img_id' => 'isPostiveInteger',
	];

	protected $scene = [
        'create' => ['name','description','head_img_id'],
        'update' => ['name','description','head_img_id']
	];
}