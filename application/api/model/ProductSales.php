<?php

namespace app\api\model;

class ProductSales extends BaseModel
{
	protected $hidden = ['product_id','create_time','delete_time','update_time'];

	public static function addSales($productStatus)
	{
		$nowMonth = date('Ymd');
		$product = self::where('product_id',$productStatus['id'])
						->where('FROM_UNIXTIME(create_time, \'%Y%m%d\')', $nowMonth)
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

	public static function countSalesToNow($countTime, $productId, $countDataFromat = '%Y%m')
	{
		$productSales = new self;

		if (!is_null($productId)) {
			$productSales->where('product_id', $productId);
		}

		return $productSales->where('create_time','EGT',$countTime)
						->field("SUM(sales) AS month_sales,SUM(counts) AS month_counts,FROM_UNIXTIME(create_time,'{$countDataFromat}') AS count_date")
						->group('count_date')
						->select();

		// echo $productSales::getLastSql();

		// return $productSales;
	}
}