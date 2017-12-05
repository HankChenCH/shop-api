<?php

namespace app\api\validate;

class GroupNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'description' => 'require|isNotEmpty',
		'admin_group' => 'checkIDs',
	];

	protected $scene = [
		'create' => ['name', 'description'],
		'update' => ['name', 'description'],
		'allot' => ['admin_group']
	];
}
