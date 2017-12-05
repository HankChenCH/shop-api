<?php

namespace app\lib\exception;

class GroupException extends BaseException
{
	public $code = 404;
	public $msg = '群组不存在';
	public $errorCode = 71000;
}
