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
use app\api\model\ProductBuynow as BuyNowModel;
use app\api\model\ProductDetail;
use app\api\model\ProductProperty;
use app\api\model\BuyNowRedis;
use app\api\model\ProductRedis;
use app\lib\exception\ProductException;
use app\lib\exception\BuyNowException;

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

	public static function createBuyNow($productID, $buyNowData)
	{
		$buyNow = BuyNowModel::createOne($productID, $buyNowData);
		$product = ProductModel::getProductDetail($productID);

		if (!$buyNow) {
			throw new BuyNowException([
				'msg' => '开启秒杀失败'
			]);
		}

		$productRedis = new ProductRedis($productID);
		$buyNowRedis = new BuyNowRedis($buyNow->id);

		$ttl = $buyNow->end_time - time() + config('setting.order_close_time') * 60;

		if (!$buyNowRedis->cacheData($buyNow, $ttl)) {
			throw new BuyNowException([
				'msg' => '秒杀开启成功，但缓存秒杀数据失败'
			]);	
		}

		if (!$buyNowRedis->cacheStock($buyNow->stock, $ttl)) {
			throw new BuyNowException([
				'msg' => '秒杀开启成功，但缓存秒杀库存失败'
			]);
		}

		if (!$productRedis->cacheData($product, $ttl)) {
			throw new BuyNowException([
				'msg' => '秒杀开启成功，但缓存商品数据失败'
			]);	
		}

		return $buyNow;
	}

	public static function getProductAllDetail($id)
	{
		$product = ProductRedis::getData($id);

        if ($product) {
        	return $product;
        }

        $product = ProductModel::getProductDetail($id);

        if (!$product) {
        	throw new ProductException();
        }

        return $product;
	}
}
