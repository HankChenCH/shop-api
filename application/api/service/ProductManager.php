<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\Product;
use app\api\model\Theme;
use app\api\model\ThemeProduct;

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

	public static function managerByTheme($themeId, $newProductIds='')
	{
		$product = self::clearByTheme($themeId);

		if ($newProductIds !== '') {
			$themeProduct = new ThemeProduct();
			$newProductIdArr = explode(',', $newProductIds);
			$data = array_map(function ($v) use ($themeId){
				return ['theme_id' => $themeId, 'product_id' => $v];
			}, $newProductIdArr);

			$themeProduct->saveAll($data);
		}
		
		return $themeProduct;
	}

	public static function clearByCategory($categoryIds)
	{
		$product = Product::where('category_id', 'in', $categoryIds)
						->update(['category_id' => 0]);

		return $product;
	}

	public static function clearByTheme($themeId)
	{
		$product = ThemeProduct::destroy(['theme_id' => $themeId]);

		return $product;
	}

}