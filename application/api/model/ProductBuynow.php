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

	// public function getStartTimeAttr($value, $data)
	// {
	// 	return $this->timeFormat($value, $data, 'Y-m-d H:i');
	// }

	// public function getEndTimeAttr($value, $data)
	// {
	// 	return $this->timeFormat($value, $data, 'Y-m-d H:i');
	// }
}