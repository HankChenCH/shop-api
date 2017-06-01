<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/29
 * Time: 12:47
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $errorCode = 30000;
    public $msg = '指定主题不存在，请检查主题ID';
}