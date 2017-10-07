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
    protected static $instance;
    protected $deleteTime = 'delete_time';

    public static function getAllBySearch($search)
    {
        self::getInstance();
        $models = self::$instance;
        foreach ($search as $key => $value) {

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'name':
                case 'true_name':
                case 'nick_name':
                    $models->where($key, 'like', "%{$value}%");

                    break;

                case 'create_time': 

                    if (is_array($value) && !is_numeric($value[0])) {
                        array_walk($value, function(&$v){
                            $v = strtotime($v);
                        });
                    } 

                    $models->where($key,'between',$value);

                    break;

                default:

                    $models->where($key, '=', $value);

                    break;
            }
        }

        $models->order('create_time desc');
        return $models;
    }

    public static function batchUpdate($ids, $data)
    {
        self::getInstance();
        $models = self::$instance;

        $models->save($data,function($query) use ($ids){
            $query->where('id','in',$ids);
        });

        return $models;
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

    protected function timeFormat($value, $data, $format="Y-m-d H:i:s")
    {
        return date($format, $value);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $class = get_called_class();
            self::$instance = (new $class);
        }
    }

    protected static function mergeIdAndData($idName, $id, $data)
    {
        return array_merge([$idName => $id], $data);
    }
}