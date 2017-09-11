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

    public function getAllBySearch($search)
    {
        foreach ($search as $key => $value) {

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'name':
                case 'true_name':
                case 'nick_name':
                    $this->where($key, 'like', "%{$value}%");

                    break;

                case 'create_time': 

                    if (is_array($value) && !is_numeric($value[0])) {
                        array_walk($value, function(&$v){
                            $v = strtotime($v);
                        });
                    } 

                    $this->where($key,'between',$value);

                    break;

                default:

                    $this->where($key, '=', $value);

                    break;
            }
        }

        $this->order('create_time desc');
        return $this;
    }
	
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