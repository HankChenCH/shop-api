<?php

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\model\ProductSales;

class Count extends BaseController
{
	public function getDashboardData()
	{
		//用户总量
		$numberUser = User::count();

		//用户月活量
		$thisMonth = strtotime(date('Y-m') . '-01');
		$numberUserMonth = User::where('update_time', 'EGT', $thisMonth)
							->count();

		//上月销量
		$countStartTime = strtotime(date('Y-m') . '-01 -1 month');
		$countEndTime = strtotime(date('Y-m') . '-01 -1 day');
		$numberSalesLastMonth = ProductSales::where('create_time','EGT',$countStartTime)
							->where('create_time', 'LT', $countEndTime)
							->sum('sales');
		//本月销量
		$numberSalesThisMonth = ProductSales::where('create_time','EGT',$thisMonth)
							->sum('sales');

		return [
			[
				"icon" => 'user', 
				"color" => '#292929', 
				"title" => '用户总量', 
				"number" => $numberUser,
			],
			[
				"icon" => 'eye-o', 
				"color" => '#292929', 
				"title" => '月活总量', 
				"number" => $numberUserMonth,
			],
			[
				"icon" => 'bulb', 
				"color" => '#292929', 
				"title" => '上月销量', 
				"number" => $numberSalesLastMonth,
			],
			[
				"icon" => 'api', 
				"color" => '#292929', 
				"title" => '本月销量', 
				"number" => $numberSalesThisMonth,
			]
		];
	}
}