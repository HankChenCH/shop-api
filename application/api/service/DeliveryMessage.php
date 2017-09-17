<?php

namespace app\api\service;

use app\api\model\User as UserModel;
use app\lib\exception\OrderExpcetion;

class DeliveryMessage extends WxMessage
{
	const DELIVERY_MSG_ID = 'ZDPKlRa5xM9R06aXCZu_c8VqKIBLSOspTXP';

	public function send($order, $tplJumpPage = '')
	{
		if (!$order) {
			throw new OrderExpcetion();
		}

		$this->tplID = self::DELIVERY_MSG_ID;
		$this->formID = $order->prepay_id;
		$this->page = $tplJumpPage;
		$this->prepareMessage($order);
		$this->emphasisKeyWord = 'keyword2.DATA';
		return parent::sendMessage($this->getUserOpenID($order->user_id));
	}

	private function prepareMessage($order)
	{
		$data = [
			'keyword1' => [
				'value' => $order->order_no,
			],
			'keyword2' => [
				'value' => $order->snap_name,
				'color' => '#27408B',
			],
			'keyword3' => [
				'value' => $order->total_price,
			],
			'keyword4' => [
				'value' => $order->snap_express->express_name,
			],
			'keyword5' => [
				'value' => $order->snap_express->express_no,
			]
		];

		$this->data = $data;
	}

	private function getUserOpenID($userID)
	{
		$user = UserModel::where('id', $userID)
						->find();

		if (!$user) {
			throw new UserException();
		}

		return $user['openid'];
	}
}