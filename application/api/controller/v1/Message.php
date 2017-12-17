<?php

namespace app\api\controller\v1;

use app\api\model\ChatMessage as MessageModel;
use app\api\service\Message as MessageService;
use app\api\service\Token as TokenService;
use app\api\validate\MessageSend;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ChatException;
use app\lib\enum\ChatTypeEnum;

class Message extends BaseController
{
	public function getList($id, $to_type='1', $page=1, $pageSize=10)
	{
		(new IDMustBePostiveInt())->goCheck();

		if($to_type === ChatTypeEnum::GROUP){

			$messages = MessageModel::with(['sender'])
						->where('to_type', $to_type)
						->where('to_id', $id)
						->order('create_time desc')
						->paginate($pageSize,false,['page' => $page]);

		} elseif ($to_type === ChatTypeEnum::MEMBER) {
			$uid = TokenService::getCurrentUid();
			$messages = MessageModel::with(['sender'])
						->where(function ($query) use ($id, $uid, $to_type){
							$query->where('to_type', $to_type)->where('from_id', $id)->where('to_id', $uid);
						})
						->whereOr(function ($query) use ($id, $uid, $to_type){
							$query->where('to_type', $to_type)->where('from_id', $uid)->where('to_id', $id);
						})
						->order('create_time desc')
						->paginate($pageSize, false, ['page' => $page]);
		}

		//if ($messages->isEmpty()) {
		//	throw new ChatException();
		//}

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
