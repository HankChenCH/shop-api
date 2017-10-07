<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\api\model\ProductSales as ProductSalesModel;
use app\api\model\ProductDetail;
use app\api\model\ProductProperty;

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

	public static function createOrUpdateProperties($productID, $data)
	{
		//真实删除产品所有属性然后批量增加，达到修改的目的
		$productProps = ProductProperty::destroy(['product_id' => $productID], true);

		array_walk($data, function (&$value) use ($productID) {
			$value['product_id'] = $productID;
		});

		$productProps = new ProductProperty;
		$pp = $productProps->saveAll($data);

		return $pp;
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

	public static function countSales($countMonth, $productID = NULL)
	{
		$needCountYear = (int)date('Y');
		$needCountMonth = (int)date('m');
		$countMonth -= 1;

		if ($countMonth > $needCountMonth) {
			$monthNum  = $countMonth % 12;
			$yearNum = intval($countMonth / 12);
			$needCountYear -= $yearNum;
			$needCountMonth = 12 - $monthNum;
		} else {
			$needCountMonth = $needCountMonth - $countMonth;
		}

		$countTime = strtotime($needCountYear . '-' . $needCountMonth . '-01');
		
		$productSales = ProductSalesModel::countSalesToNow($countTime, $productID);

		return $productSales;
	}
}