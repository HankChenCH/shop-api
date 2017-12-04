<?php

namespace app\lib\exception;

class ResourceException extends BaseException
{
	public $code = 404;
    public $msg = '资源不存在';
    public $errorCode = 70010;
}