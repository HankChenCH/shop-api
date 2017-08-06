<?php

namespace app\lib\exception;

class AdminException extends BaseException
{
	public $code = 404;
    public $msg = '管理员不存在';
    public $errorCode = 800003;
}