<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:53
 */

namespace app\lib\exception;


class SearchwordException extends BaseException
{
    public $code = 404;
    public $msg = '没有搜索历史';
    public $errorCode = '800000';
}