<?php

namespace app\api\service;

use app\api\model\User as UserModel;
use app\lib\exception\OrderExpcetion;

class IssueMessage extends WxMessage
{
	const ISSUE_MSG_ID = 'ZDPKlRa5xM9R06aXCZu_c-4pUClbDOB0SWbrhaBUd0g';

	public function send($order, $tplJumpPage = '')
	{
		if (!$order) {
			throw new OrderExpcetion();
		}

		$this->tplID = self::ISSUE_MSG_ID;
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
				'value' => $this->renderTicketInfo($order->snap_items),
			],
		];

		$this->data = $data;
	}

	private function renderTicketInfo($orderItemsData)
	{
		$tpl = '票号：';

		foreach ($orderItemsData as $key => $value) {
			if ($key > 0) {
				$tpl .= '等';
				break;
			}
			$tpl .= $value->ticket[0];
		}

		return $tpl;
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