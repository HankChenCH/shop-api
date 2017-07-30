<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 8:53
 */

namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class BaseModel extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	
    protected function imgPrefix($value,$data)
    {
        $finUrl = $value;
        if($data['from'] == 1){
            $finUrl = config('setting.img_prefix') . $value;
        }
        return $finUrl;
    }
}