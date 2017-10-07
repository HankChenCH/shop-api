<?php

namespace app\lib\exception;

class BuyNowException extends BaseException
{
	public $code = 404;
    public $msg = '秒杀不存在';
    public $errorCode = 20010;
}