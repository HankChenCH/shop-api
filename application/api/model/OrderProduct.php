<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class OrderProduct extends BaseModel
{
	protected $hidden = ['delete_time', 'update_time'];

	public function order()
	{
		return $this->belongsTo('Order', 'order_id', 'id');
	}
}