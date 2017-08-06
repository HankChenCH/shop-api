<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\lib\exception\ImageException;
use app\api\service\Image as ImageService;

class Image
{
	public function uploadCategoryTopicImage()
	{
		 $file = request()->file('topicImage');
    
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate(['size'=>156780,'ext'=>'jpg,png'])
	    			->move(ROOT_PATH . 'public' . DS . 'images' . DS . 'category');
	    if($info){
	        // 成功上传后 获取上传信息
	        $image = new ImageModel;
	        $image->from = SaveFileFromEnum::LOCAL;
	        $image->url = '/category/' . str_replace('\\', '/', $info->getSaveName());
	        if ($image->save()){
	        	$image->visible(['id','url','create_time']);
		        return $image;
	        };
	    }else{
	        // 上传失败获取错误信息
	        throw new UploadException([
	        	'msg' => $file->getError() 
	        ]);
	    }
	}

	public function uploadProductMainImage()
	{
		$image = ImageService::uploadToLocal('mainImage', 'product', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
        	throw new ImageException([
        		'msg' => '上传图片失败'
        	]);
        }

        return $image;
	}
}