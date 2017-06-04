<?php

namespace app\lib\exception;

class SuccessMessage extends BaseException
{
	public $code = 201;
	public $errorCode = 0;
	public $msg = '操作成功';
}