<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/29
 * Time: 12:47
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $errorCode = 10001;
    public $msg = 'Token已过期或者无效Token';
}