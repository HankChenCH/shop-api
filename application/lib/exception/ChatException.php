<?php

namespace app\lib\exception;

class ChatException extends BaseException
{
	public $code = 404;
	public $msg = '消息列表为空';
	public $errorCode = 700012;
}