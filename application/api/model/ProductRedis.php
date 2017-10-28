<?php

namespace app\api\model;

class ProductRedis extends BaseRedis
{
	protected $keyPrefix = 'product_';

	protected $keyID;

	public function __construct($productID)
	{
		$this->dataPrefix = $this->keyPrefix . 'data:';
		$this->keyID = $productID;
	}
}
