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

    public function getDataOnScene($arrays)
    {
        $scene = $this->currentScene;
        $paramKeys = $this->scene[$scene];
        $paramArray = [];

        foreach ($paramKeys as $k => $v) {
            if (array_key_exists($v, $arrays)) {
                $paramArray[$v] = $arrays[$v];
            }

            if (array_key_exists($k, $arrays)) {
                $paramArray[$k] = $arrays[$k];
            }            
        }

        return $paramArray;
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

    protected function endTimeMustLagerStartTime($value, $rule='', $data, $field='')
    {
        $endTime = $this->toTimeStamp($data['end_time']);
        $startTime = $this->toTimeStamp($data['start_time']);

        if ($end_time - $start_time > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        $value = trim($value);
        if (!empty($value)){
            return true;
        }
        else{
            return false;
//            return $field . '必须为整数';
        }
    }

    protected function isMobile($value)
    {
        $pattern = '/^1(3|5|8)\d{9}$/';
        if (!preg_match($pattern, $value)) {
            return false;
        }

        return true;
    }

    protected function isPhone($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        return true;
    }

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

    protected function toTimeStamp($value) 
    {
        if (!is_numeric($value)) {
            return strtotime($value);
        }

        return $value;
    }
}