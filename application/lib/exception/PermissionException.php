<?php

namespace app\lib\exception;

class PermissionException extends BaseException
{
	public $code = 401;
	public $msg = 'Permission denied';
	public $errorCode = 400001;
}
