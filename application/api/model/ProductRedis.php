<?php

namespace app\api\model;

class ProductRedis extends BaseRedis
{
	protected $keyPrefix = 'product_';

	protected $keyID;

	public function __construct($productID)
	{
		parent::__construct();
		$this->keyID = $productID;
	}
}
