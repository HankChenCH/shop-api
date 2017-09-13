<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;


class Express
{
	public function getSetting()
	{
		return [
			'express_price' => config('setting.express_price'),
			'express_limit' => config('setting.express_limit'),
		];
	}
}