<?php

namespace app\api\model;

class ProductSales extends BaseModel
{
	protected $hidden = ['product_id','create_time','delete_time','update_time'];

	public static function addSales($productStatus)
	{
		$nowMonth = date('Ym');
		$product = self::where('product_id',$productStatus['id'])
						->where('FROM_UNIXTIME(create_time, \'%Y%m\')', $nowMonth)
						->find();

		if (!$product) {
			self::createSales($productStatus);
		} else {
			$product->updateSales($productStatus);
		}
	}

	private static function createSales($productStatus)
	{
		self::create([
			'product_id' => $productStatus['id'],
			'sales' => $productStatus['totalPrice'],
			'counts' => $productStatus['counts'],
		]);
	}

	private function updateSales($productStatus)
	{
		$this->setInc('sales', $productStatus['totalPrice']);
		$this->setInc('counts', $productStatus['counts']);
	}
}