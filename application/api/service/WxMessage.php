<?php

namespace app\api\service;

use think\Exception;
use think\Log;

class WxMessage
{
	private $sendUrl = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s";
	private $touser;
	private $color = '#292929';

	protected $tplID;
	protected $page;
	protected $formID;
	protected $data;
	protected $emphasisKeyWord;

	public function __construct()
	{
		$accessToken = new AccessToken();
		$token = $accessToken->get();
		$this->sendUrl = sprintf($this->sendUrl, $token);
	}

	protected function sendMessage($openID)
	{
		$data = [
			'touser' => $openID,
			'template_id' => $this->tplID,
			'page' => $this->page,
			'form_id' => $this->formID,
			'data' => $this->data,
			'emphasisKeyWord' => $this->emphasisKeyWord
		];

		$result = curl_post($this->sendUrl, $data);
		$result = json_decode($result, true);

		if ($result['errcode'] == 0) {
			return true;
		} else {
			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($result,'error');
			throw new Exception('模板消息发送失败，' . $result['errmsg']);
		}
	}
}