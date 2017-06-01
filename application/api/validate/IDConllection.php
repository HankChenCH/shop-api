<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:20
 */

namespace app\api\validate;


class IDConllection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids必须是以逗号分隔的正整数'
    ];

    protected function checkIDs($value)
    {
        if (empty($value)){
            return false;
        }
        $values = explode(',',$value);
        foreach ($values as $id){
            if(!$this->isPostiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}