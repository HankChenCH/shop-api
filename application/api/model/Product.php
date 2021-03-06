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
	protected $hidden = ['pivot','update_time','delete_time','category_id'];

	public function getMainImgUrlAttr($value,$data)
	{
		return $this->imgPrefix($value,$data);
	}

	public function imgs()
	{
		return $this->hasMany('ProductImage','product_id','id');
	}

	public function properties()
	{
		return $this->hasMany('ProductProperty','product_id','id');
	}

	public function details()
	{
		return $this->hasOne('ProductDetail');
	}

	public function buyNow()
	{
		return $this->hasMany('ProductBuynow', 'product_id', 'id');
	}

	public static function getMostRecent($count)
	{
		$products = self::where('is_on', '1')
			->where('type','1')
			->limit($count)
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

	public static function getProductDetail($id)
	{
        // $product = self::with([
        //         'imgs' => function($query){
        //             $query->with(['imgUrl'])
        //                 ->order('order','ASC');
        //         }
        // 	])
        $product = self::with(['properties'])
        	->with(['details'])
        	->find($id);

        return $product;
	}

	public static function getProductsByKeyWord($keyword, $page, $size)
	{
		$products = self::where('name','like',"%{$keyword}%")
			->order('id','DESC')
			->paginate($size,true,['page' => $page]); 

		return $products;
	}

	// public static function getAllBySearch($name, $create_time)
	// {
	// 	$products = new self;
		
	// 	if (!empty($name)) {
	// 		$products->where('name','like',"%{$name}%");
	// 	}

	// 	if (count($create_time) == 2) {

	// 		if (!is_numeric($create_time[0])) {
 //                array_walk($create_time, function(&$v){
 //                    $v = strtotime($v);
 //                });
 //            }

	// 		$products->where('create_time','between',$create_time);
	// 	}

	// 	$products->order('create_time desc');

	// 	return $products;
	// }
}