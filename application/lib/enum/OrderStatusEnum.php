<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\lib\enum;

class OrderStatusEnum
{
	const UNPAID = 1;
	const PAID = 2;
	const DELIVERED = 3;
	const PAID_BUT_OUT_OF = 4;
}