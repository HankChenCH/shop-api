<?php

namespace app\api\validate;


class CategoryInfo extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'description' => 'require|isNotEmpty',
		'topic_img_id' => 'require|isPostiveInteger'
	];

	protected $scene = [
        'create' => ['name','description','topic_img_id'],
        'update' => ['name','description','topic_img_id'],
	];
}