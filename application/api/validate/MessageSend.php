<?php

namespace app\api\validate;

class MessageSend extends BaseValidate
{
	protected $rule = [
		'message' => 'require|isNotEmpty',
		'to_id' => 'require|isPostiveInteger',
		'to_type' => 'require|isNotEmpty',
	];

	protected $scene = [
		'send' => ['message', 'to_id', 'to_type']
	];
}
