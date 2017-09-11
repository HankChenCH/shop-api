<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 8:53
 */

namespace app\api\model;

use think\Model;
use app\lib\enum\SaveFileFromEnum;
use traits\model\SoftDelete;

class BaseModel extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	
    protected function imgPrefix($value,$data)
    {
        $finUrl = $value;
        if ($data['from'] == SaveFileFromEnum::LOCAL) {
            $finUrl = config('setting.img_prefix') . $value;
        } elseif($data['from'] == SaveFileFromEnum::QINIU) {
            $finUrl = config('setting.qiniu_prefix') . $value;
        }
        return $finUrl;
    }
}