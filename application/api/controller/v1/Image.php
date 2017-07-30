<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\api\model\Image as ImageModel;


class Image
{
	public function uploadCategoryTopicImage()
	{
		 $file = request()->file('topicImage');
    
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->move(ROOT_PATH . 'public' . DS . 'images');
	    if($info){
	        // 成功上传后 获取上传信息
	        $image = new ImageModel;
	        $image->from = 1;
	        $image->url = '/' . str_replace('\\', '/', $info->getSaveName());
	        if ($image->save()){
	        	$image->visible(['id','url','create_time']);
		        return $image;
	        };
	    }else{
	        // 上传失败获取错误信息
	        throw new uploadException([
	        	'msg' => $file->getError() 
	        ]);
	    }
	}
}