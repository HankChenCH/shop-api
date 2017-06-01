<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/20
 * Time: 21:44
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = '100000';
}