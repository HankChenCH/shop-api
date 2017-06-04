<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
	protected $hidden = ['img_id','delete_time','product_id'];

	public function imgUrl()
	{
		return $this->belongsTo('Image','img_id','id');
	}
}