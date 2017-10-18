<?php

namespace app\api\model;

class BuyNowRedis extends BaseRedis
{
	const KEY_PREFIX = 'buynow_';
	protected $batchID;

	public function __construct($buyNowID)
	{
		$this->batchID = $buyNowID;
	}

	public function cacheData($data)
	{
		$redis = self::getRedis();

		return $redis->setNx(self::KEY_PREFIX . 'data:' . $this->batchID, serialize($data));
	}

	public function cacheStock($stock)
	{
		$redis = self::getRedis();

		return $redis->setNx(self::KEY_PREFIX . 'stock:' . $this->batchID, $stock);
	}

	public static function get($buyNowID)
	{
		$redis = self::getRedis();
		$buyNow = $redis->get(self::KEY_PREFIX . 'data:' . $buyNowID);
		return unserialize($buyNow);
	}

	public static batchDecrStock($orderProduct)
	{
		$redis = self::getRedis();
		
		foreach ($orderProduct as $singleProduct) {
			if ($redis->decr(self::KEY_PREFIX . 'stock:' . $singleProduct['batch_id'], $singleProduct['counts']) < 0) {
				return false;
			}
		}

		return true;
	}
}
