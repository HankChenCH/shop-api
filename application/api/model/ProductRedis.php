<?php

namespace app\api\model;

class ProductRedis extends BaseRedis
{
	protected static $keyPrefix = 'product_';

	protected $keyID;

	public function __construct($productID)
	{
		$this->keyID = $productID;
	}
}
