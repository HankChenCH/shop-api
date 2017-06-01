<?php

namespace app\lib\exception;

class ProductException extends BaseException
{
	public $code = 404;
	public $errorCode = 20000;
	public $msg = '指定商品不存在，请确定商品ID';
}