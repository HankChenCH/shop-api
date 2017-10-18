<?php

namespace app\api\model;

class BuyNowRedis extends BaseRedis
{
	const KEY_PREFIX = 'buynow_';
	protected $dataPrefix = self::KEY_PREFIX . 'data:';
	protected $stockPrefix = self::KEY_PREFIX . 'stock:';
	protected $batchID;

	public function __construct($buyNowID)
	{
		$this->batchID = $buyNowID;
	}

	public function cacheData($data)
	{
		$redis = self::getRedis();

		return $redis->setNx($this->dataPrefix . $this->batchID, serialize($data));
	}

	public function cacheStock($stock)
	{
		$redis = self::getRedis();

		return $redis->setNx($this->stockPrefix . $this->batchID, $stock);
	}

	public static function getData($buyNowID, $syncStock = true)
	{
		$redis = self::getRedis();

		$buyNow = $redis->get($this->dataPrefix . $buyNowID);

		if ($syncStock) {
			$nowStock = self::getStock($buyNowID);
			$buyNow->stock = intval($nowStock);
		}

		return unserialize($buyNow);
	}

	public static function getStock($buyNowID)
	{
		$redis = self::getRedis();

		return $redis->get($this->stockPrefix . $buyNowID);
	}

	public static function batchDecrStock($orderProduct)
	{
		$redis = self::getRedis();
		
		foreach ($orderProduct as $singleProduct) {
			if ($redis->decr($this->stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']) < 0) {
				$redis->incr($this->stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']);
				return false;
			}
		}

		return true;
	}
}
