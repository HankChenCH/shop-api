<?php

namespace app\lib\exception;

class UploadException extends BaseException
{
	public $code = 417;
    public $msg = '上传文件失败';
    public $errorCode = 500003;
}