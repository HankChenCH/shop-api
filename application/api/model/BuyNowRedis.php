<?php

namespace app\api\model;

class BuyNowRedis extends BaseRedis
{
	protected $keyPrefix = 'buynow_';

	protected $stockPrefix;

	public function __construct($buyNowID)
	{
		$this->dataPrefix = $this->keyPrefix . 'data:';
		$this->stockPrefix = $this->keyPrefix . 'stock:';
		$this->keyID = $buyNowID;
	}

	public function cacheStock($stock, $liveTime = 600)
	{
		$redis = self::getRedis();

		return $redis->setEx($this->stockPrefix . $this->keyID, $liveTime, $stock);
	}

	public function getData($buyNowID, $syncStock = true)
	{
		$buyNowObj = parent::getData($buyNowID);

		if ($syncStock && $buyNowObj) {
			$nowStock = $this->getStock($buyNowID);
			$buyNowObj->stock = intval($nowStock);
		}

		return $buyNowObj;
	}

	public function getStock($buyNowID)
	{
		$redis = self::getRedis();

		return $redis->get($this->stockPrefix . $buyNowID);
	}

	public function incrStock($buyNowID, $counts = 0)
	{
		$redis = self::getRedis();

		return $redis->incr($this->stockPrefix . $buyNowID, $counts);
	}

	public function batchDecrStock($orderProduct)
	{
		$redis = self::getRedis();
		
		foreach ($orderProduct as $singleProduct) {
			if ($redis->decr($this->stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']) < 0) {
				$this->incrStock($singleProduct['batch_id'], $singleProduct['counts']);
				return false;
			}
		}

		return true;
	}
}
