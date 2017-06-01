<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\model;


class Category extends BaseModel
{
	protected $hidden = ['delete_time','update_time','create_time'];

	public function img()
	{
		return $this->belongsTo('Image','topic_img_id','id');
	}
}