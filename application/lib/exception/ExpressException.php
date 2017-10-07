<?php

namespace app\lib\exception;

class ExpressException extends BaseException
{
	public $code = 404;
    public $msg = '快递信息不存在';
    public $errorCode = 900003;
}