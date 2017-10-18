<?php

namespace app\api\model;

class BuyNowRedis extends BaseRedis
{
	const KEY_PREFIX = 'buynow_';
	protected static $dataPrefix = self::KEY_PREFIX . 'data:';
	protected static $stockPrefix = self::KEY_PREFIX . 'stock:';
	protected $batchID;

	public function __construct($buyNowID)
	{
		$this->batchID = $buyNowID;
	}

	public function cacheData($data)
	{
		$redis = self::getRedis();

		return $redis->setNx(self::$dataPrefix . $this->batchID, serialize($data));
	}

	public function cacheStock($stock)
	{
		$redis = self::getRedis();

		return $redis->setNx(self::$stockPrefix . $this->batchID, $stock);
	}

	public static function getData($buyNowID, $syncStock = true)
	{
		$redis = self::getRedis();

		$buyNow = $redis->get(self::$dataPrefix . $buyNowID);

		$buyNowObj = unserialize($buyNow);

		if ($syncStock) {
			$nowStock = self::getStock($buyNowID);
			$buyNowObj->stock = intval($nowStock);
		}

		return $buyNowObj;
	}

	public static function getStock($buyNowID)
	{
		$redis = self::getRedis();

		return $redis->get(self::$stockPrefix . $buyNowID);
	}

	public static function batchDecrStock($orderProduct)
	{
		$redis = self::getRedis();
		
		foreach ($orderProduct as $singleProduct) {
			if ($redis->decr(self::$stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']) < 0) {
				$redis->incr(self::$stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']);
				return false;
			}
		}

		return true;
	}
}
