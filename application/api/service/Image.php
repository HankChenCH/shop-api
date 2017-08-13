<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 8:40
 */

namespace app\api\service;

use app\api\model\Image as ImageModel;
use app\lib\exception\UploadException;
use app\lib\enum\SaveFileFromEnum;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Image
{
	public static function uploadToLocal($fileName, $uploadType, $validate)
    {
	    // 移动到框架应用根目录/public/uploads/$uoloadType 目录下
	    $info = self::moveFile($fileName, $uploadType, $validate);
	    // 成功上传后 获取上传信息
	    $image = self::saveData(SaveFileFromEnum::LOCAL, 
	    		'/' . $uploadType . '/' . str_replace(DS, '/', $info->getSaveName())
	    	);

	    return $image;
    }

    public static function uploadToQiNiu($fileName, $uploadType, $validate)
    {
		$info = self::moveFile($fileName, $uploadType, $validate);

    	require_once APP_PATH . '/../vendor/qiniu/php-sdk/autoload.php';
    	$accessKey = config('qiniu.AK');
	    $secretKey = config('qiniu.SK');
		$bucket = config('qiniu.bucket');

		$auth = new Auth($accessKey, $secretKey);
		$token = $auth->uploadToken($bucket);

		$filePath = 'images' . DS . $uploadType . DS . $info->getSaveName();
		// 上传到七牛后保存的文件名
        $key = $uploadType . '_' . substr(md5($info->getFilename()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $info->getExtension();
		// 初始化 UploadManager 对象并进行文件的上传
	    $uploadMgr = new UploadManager();
	    // 调用 UploadManager 的 putFile 方法进行文件的上传
	    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

	    if ($err !== null) {
	        throw new UploadException([
	        	'msg' => '上传七牛图床失败' 
	        ]);
	    } 

	    // var_dump($ret);
	    $image = self::saveData(SaveFileFromEnum::QINIU, '/' . $ret['key']);
	    return $image;
    }

    private static function moveFile($fileName, $uploadType, $validate)
    {
    	$file = request()->file($fileName);
    
	    // 移动到框架应用根目录/public/uploads/$uploadType 目录下
	    $info = $file->validate($validate)
	    			->move(ROOT_PATH . 'public' . DS . 'images' . DS . $uploadType);

	    if (!$info) {
	    	// 上传失败获取错误信息
	        throw new UploadException([
	        	'msg' => $file->getError() 
	        ]);
	    }

	    return $info;
    }

    private static function saveData($from, $url)
    {
    	$image = ImageModel::create([
	    	'from' => $from,
	    	'url' => $url,
	    ]);

		$image->visible(['id','from','url','create_time']);
	    return $image;
    }
}