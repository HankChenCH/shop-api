<?php

namespace app\api\model;

class BuyNowRedis extends BaseRedis
{
	protected $keyPrefix = 'buynow_';

	protected $stockPrefix;

	public function __construct($buyNowID)
	{
		parent::__construct();
		$this->stockPrefix = $this->keyPrefix . 'stock:';
		$this->keyID = $buyNowID;
	}

	public function cacheStock($stock, $liveTime = 600)
	{
		$redis = self::getRedis();

		return $redis->setEx($this->$stockPrefix . $this->keyID, $liveTime, $stock);
	}

	public static function getData($buyNowID, $syncStock = true)
	{
		$buyNowObj = parent::getData($buyNowID);

		if ($syncStock && $buyNowObj) {
			$nowStock = self::getStock($buyNowID);
			$buyNowObj->stock = intval($nowStock);
		}

		return $buyNowObj;
	}

	public static function getStock($buyNowID)
	{
		$redis = self::getRedis();

		return $redis->get($this->$stockPrefix . $buyNowID);
	}

	public static function incrStock($buyNowID, $counts = 0)
	{
		$redis = self::getRedis();

		return $redis->incr($this->$stockPrefix . $buyNowID, $counts);
	}

	public static function batchDecrStock($orderProduct)
	{
		$redis = self::getRedis();
		
		foreach ($orderProduct as $singleProduct) {
			if ($redis->decr($this->$stockPrefix . $singleProduct['batch_id'], $singleProduct['counts']) < 0) {
				self::incrStock($singleProduct['batch_id'], $singleProduct['counts'])
				return false;
			}
		}

		return true;
	}
}
