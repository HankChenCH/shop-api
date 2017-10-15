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

class Image extends BaseController
{
    // protected $beforeActionList = [
    //     'checkAdminScope' => ['only' => 'uploadThemeTopicImage,uploadThemeHeadImage,uploadCategoryTopicImage,uploadProductMainImage,uploadProductDetailImage'],
    // ];

    public function uploadThemeTopicImage()
    {
        $image = ImageService::uploadToQiNiu('topicImage', 'theme', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
                'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }

    public function uploadThemeHeadImage()
    {
        $image = ImageService::uploadToQiNiu('headImage', 'theme', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
                'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }

    public function uploadCategoryTopicImage()
    {
        $image = ImageService::uploadToQiNiu('topicImage', 'category', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
        	   'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }

    public function uploadProductMainImage()
    {
        $image = ImageService::uploadToQiNiu('mainImage', 'product', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
        	   'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }

    public function uploadProductDetailImage()
    {
        $image = ImageService::uploadToQiNiu('detailImage', 'product_detail', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
                'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }

    public function uploadBuyNowRulesImage()
    {
        $image = ImageService::uploadToQiNiu('rulesImage', 'buy_now_rules', ['size'=>156780,'ext'=>'jpg,png']);

        if (!$image){
            throw new ImageException([
                'msg' => '保存图片失败'
            ]);
        }

        return $image;
    }
}