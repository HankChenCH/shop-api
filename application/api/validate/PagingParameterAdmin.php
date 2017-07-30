<?php

namespace app\api\validate;


class PagingParameterAdmin extends BaseValidate
{
	protected $rule = [
		'page' => 'isPostiveInteger',
		'pageSize' => 'isPostiveInteger'
	];

	protected $message = [
		'page' => '分页参数必须是正整数',
		'pageSize' => '分页参数必须是正整数'
	];
}