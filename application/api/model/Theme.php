<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:09
 */

namespace app\api\model;

use app\lib\exception\ThemeException;
use think\Db;

class Theme extends BaseModel
{
    protected $hidden = ['update_time','delete_time','head_img_id'];

    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products()
    {
         return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $themes = self::with('products,headImg')
            ->find($id);

        return $themes;
    }

    public static function getProducts($id)
    {
        $themes = self::with('products')
            ->find($id);

        return $themes;
    }

    public static function resetRank($ranks)
    {
        // Db::startTrans();

        // var_dump($ranks);
        // exit;

        // try{

            $themes = new self();

            $themes->save(['rank' => 999]);

            $themes->saveAll($ranks);

            // Db::commit();

            return $themes;

        // } catch (\Exception $e) {

        //     Db::rollback();
        //     throw new ThemeException([
        //         'msg' => '主题更新排序失败'
        //     ]);
        // }
    }
}