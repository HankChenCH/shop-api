<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/27
 * Time: 20:19
 */

namespace app\lib\exception;


use Exception;
use think\Log;
use think\Request;
use think\exception\Handle;

class ExceptionHandle extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //Url

    public function render(Exception $e)
    {
        if ($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            //如果是开发环境就返回原始错误处理结果
             if (config('app_debug')) {
                 return parent::render($e);
             }else{
                 $this->code = 500;
                 $this->msg = '服务器内部错误';
                 $this->errorCode = 999;
                 $this->recordErrorLog($e);
             }
        }

        $request = Request::instance();

        $result = [
            'errorCode' => $this->errorCode,
            'msg' => $this->msg,
            'request_url' => $request->url()
        ];

        return json($result,$this->code);
    }

    private function recordErrorLog(Exception $e)
    {
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}