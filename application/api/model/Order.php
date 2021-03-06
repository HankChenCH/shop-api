<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;

use app\lib\enum\OrderStatusEnum;


class Order extends BaseModel
{
	protected $hidden = ['delete_time','update_time'];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function logs()
	{
		return $this->hasMany('OrderLog','order_id', 'id');
	}

	public function products()
	{
		return $this->hasMany('OrderProduct','order_id','id');
	}

	public function getSnapItemsAttr($value)
	{
		if (empty($value)) {
			return null;
		}
		return json_decode($value);
	}

	public function getSnapAddressAttr($value)
	{
		if (empty($value)) {
			return null;
		}
		return json_decode($value);
	}

	public function getSnapExpressAttr($value)
	{
		if (empty($value)) {
			return null;
		}

		return json_decode($value);
	}

	public function getPayTimeAttr($value)
	{
		if (empty($value)) {
			return null;
		}

		return date('Y-m-d H:i:s',$value);
	}

	public function getDeliveryTimeAttr($value)
	{
		if (empty($value)){
			return null;
		}

		return date('Y-m-d H:i:s', $value);
	}

	public static function getSummaryByUser($uid, $page=1, $size=15, $status)
	{
		$paingData = self::where('user_id','=',$uid)
			->where('status', 'in', $status)
			->order('create_time desc')
			->paginate($size,true,['page' => $page]);

		return $paingData;
	} 

	public static function close($column, $op, $value)
	{
		return self::where($column, $op, $value)
				->where('status', 'EQ', OrderStatusEnum::UNPAID)
				->update(['status' => OrderStatusEnum::CLOSED]);
	}
}
