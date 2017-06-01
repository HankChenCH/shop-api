<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:49
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if($result){
            return true;
        }
        else{
            throw new ParameterException([
                'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
            ]);
        }
    }

    protected function isPostiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }
        else{
            return false;
//            return $field . '必须为整数';
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (!empty($value)){
            return true;
        }
        else{
            return false;
//            return $field . '必须为整数';
        }
    }
}