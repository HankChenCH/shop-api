<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 20:44
 */

namespace app\lib\exception;

class ForbiddenException extends BaseException
{
	public $code = 403;
	public $msg = '权限不足';
	public $errorCode = 100001;
}