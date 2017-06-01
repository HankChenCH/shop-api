<?php

namespace app\lib\exception;

class CategoryException extends BaseException
{
	public $code = 404;
    public $msg = '指定的类目不存在，请确定类目ID';
    public $errorCode = 500000;
}