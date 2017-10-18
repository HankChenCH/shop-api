<?php

namespace app\api\model;

class ProductBuynow extends BaseModel
{
	protected $hidden = ['update_time', 'delete_time'];

	public static function createOne($productId, $data)
	{
		$buyNowData = self::mergeIdAndData('product_id', $productId, $data);

		$buyNow = self::create($buyNowData);

		return $buyNow;
	}
}