<?php

namespace app\lib\exception;

class ImageException extends BaseException
{
	public $code = 404;
    public $msg = '图片不存在';
    public $errorCode = 400003;
}