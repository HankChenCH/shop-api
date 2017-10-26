<?php

namespace app\api\validate;

use app\lib\exception\ThemeException;

class ThemeRank extends BaseValidate
{
	protected $rule = [
		'ranks' => 'checkRanks'
	];

	protected $singleRule = [
		'id' => 'require|isPostiveInteger',
		'rank' => 'require|number'
	];

	protected function checkRanks($values)
	{
		foreach ($values as $value) {
    		$this->checkRank($value);
    	}

        return true;
	}

	private function checkRank($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->batch()->check($value);
        if (!$result) {
            throw new ThemeException([
                'msg' => '主题排序参数错误'
            ]);
        }
    }
}