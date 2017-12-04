<?php

namespace app\api\validate;

class RoleNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'description' => 'require|isNotEmpty',
		'role_resource' => 'require|isNotEmpty',
	];

	protected $scene = [
		'create' => ['name', 'description', 'role_resource'],
		'update' => ['name', 'description', 'role_resource']
	];
}