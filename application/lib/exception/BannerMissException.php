<?php

namespace app\lib\exception;

class BannerMissException extends BaseException
{
	public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 400003;
}