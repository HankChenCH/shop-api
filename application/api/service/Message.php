<?php

namespace app\api\service;

use app\api\model\Admin as AdminModel;
use app\api\model\ChatMessage as MessageModel;
use app\lib\exception\AdminException;

class Message
{
	public static function send($data)
	{
		$uid = Token::getCurrentUid();

		$data['form_id'] = $uid;

		$admin = AdminModel::find($uid);

		if (!$admin) {
			throw new AdminException();
		}

		$message = MessageModel::create($data);

		return $message;
	}
}