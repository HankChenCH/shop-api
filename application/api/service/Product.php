<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\api\model\ProductDetail;

class Product
{
	public static function createOrUpdateDetail($productID, $data)
	{
		$product = ProductDetail::where('product_id','=',$productID)
					->find();

		if (!$product) {
			$product = self::createDetail($productID, $data);
		} else {
			$product = self::updateDetail($product, $data);
		}

		return $product;
	}

	private static function createDetail($productID, $data)
	{
		$product = ProductDetail::create([
				'product_id' => $productID,
				'detail' => $data['detail'],
			]);

		return $product;
	}

	private static function updateDetail($product, $data)
	{
		$product->save($data);

		return $product;
	}
}