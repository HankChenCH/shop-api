<?php

namespace app\lib\exception;

class RoleException extends BaseException
{
	public $code = 404;
    public $msg = '角色不存在';
    public $errorCode = 700003;
}
