<?php

namespace app\api\validate;

class ResourceNew extends BaseValidate
{
	protected $rule = [
		'name' => 'require|isNotEmpty',
		'description' => 'require|isNotEmpty',
		'resource_type' => 'require|isNotEmpty',
		'permission_type' => 'require|isNotEmpty',
	];

	protected $scene = [
		'create' => ['name', 'description', 'resource_type', 'permission_type'],
		'update' => ['name', 'description', 'resource_type', 'permission_type'],
	];
}