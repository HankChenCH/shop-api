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

class Image
{
	public static function uploadToLocal($fileName, $uploadType, $validate)
    {
    	$file = request()->file($fileName);
    
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate($validate)
	    			->move(ROOT_PATH . 'public' . DS . 'images' . DS . $uploadType);
	    if($info){
	        // 成功上传后 获取上传信息
	        $image = ImageModel::create([
	        	'from' => SaveFileFromEnum::LOCAL,
	        	'url' => '/' . $uploadType . '/' . str_replace(DS, '/', $info->getSaveName())
	        ]);

        	$image->visible(['id','from','url','create_time']);
	        return $image;

	    }else{
	        // 上传失败获取错误信息
	        throw new UploadException([
	        	'msg' => $file->getError() 
	        ]);
	    }
    }
}