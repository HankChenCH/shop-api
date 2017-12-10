<?php

namespace app\api\controller\v1;

use app\api\model\ChatMessage as MessageModel;
use app\api\service\Message as MessageService;
use app\api\validate\MessageSend;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ChatException;

class Message extends BaseController
{
	public function getList($id, $to_type='1', $page=1, $pageSize=10)
	{
		(new IDMustBePostiveInt())->goCheck();

		$messages = MessageModel::with(['sender'])
						->where('to_type', $to_type)
						->where('to_id', $id)
						->select();

		if ($messages->isEmpty()) {
			throw new ChatException();
		}

		return $messages;
	}

	public function sendMessage()
	{
		$validate = new MessageSend();
		$validate->scene('send');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$message = MessageService::send($data);

		if (!$message) {
			throw new ChatException([
				'msg' => '消息发送失败，请稍后再试'
			]);
		}

		return $message;
	}
}