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
}
