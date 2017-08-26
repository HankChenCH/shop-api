<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class ProductDetail extends BaseModel
{
	protected $hidden = ['id','create_time','delete_time','update_time'];
}