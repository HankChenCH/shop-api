<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:53
 */

namespace app\lib\exception;


class WxException extends BaseException
{
    public $code = 401;
    public $msg = '调用微信接口失败';
    public $errorCode = '999';
}