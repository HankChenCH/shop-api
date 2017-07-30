<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\Product;

class ProductManager
{
	public static function managerByCategory($categoryId, $newProductIds='')
	{
		$product = self::clearByCategory($categoryId);

		if ($newProductIds !== '') {
			$product = Product::where('id','in',$newProductIds)
						->update(['category_id' => $categoryId]);
		}
		
		return $product;
	}

	public static function clearByCategory($categoryIds)
	{
		$product = Product::where('category_id', 'in', $categoryIds)
						->update(['category_id' => 0]);

		return $product;
	}

}