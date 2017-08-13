<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class OrderLog extends BaseModel
{
	protected $hidden = ['update_time','delete_time'];
}