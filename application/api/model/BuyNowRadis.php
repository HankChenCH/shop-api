<?php

namespace app\api\model;

class BuyNowRadis extends BaseRaids
{
	const KEY_PREFIX = 'buynow_';
	protected $batchID;

	public function __constructor($buyNowID)
	{
		$this->batchID = $buyNowID;
	}

	public function cacheData($data)
	{
		$radis = self::getRadis();

		return $radis->setNx(self::KEY_PREFIX . 'data:' . $this->batchID, serialize($data));
	}

	public function cacheStock($stock)
	{
		$radis = self::getRadis();

		return $radis->setNx(self::KEY_PREFIX . 'stock:' . $this->batchID, $stock);
	}
}