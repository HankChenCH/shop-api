<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class Product extends BaseModel
{
	protected $hidden = ['pivot','create_time','update_time','delete_time','img_id','from','category_id'];

	public function getMainImgUrlAttr($value,$data)
	{
		return $this->imgPrefix($value,$data);
	}

	public static function getMostRecent($count)
	{
		$products = self::limit($count)
		    ->order('create_time desc')
		    ->select();

		return $products;
	}

	public static function getProductsByCategoryID($categoryID)
	{
		$products = self::where('category_id','=',$categoryID)
		    ->select();

		return $products;
	}
}