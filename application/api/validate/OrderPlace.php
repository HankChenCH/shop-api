<?php

namespace app\api\validate;

use app\lib\exception\ProductException;
use app\lib\exception\ExpressException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'orderProducts' => 'checkProducts',
        'orderExpress' => 'checkExpress',
    ];

    private $singleRule = [
    	'product_id' => 'require|isPostiveInteger',
    	'count' => 'require|isPostiveInteger',
        'batch_id' => 'isPostiveInteger'
    ];

    protected function checkProducts($values)
    {
    	if (!is_array($values)) {
    		throw new ProductException([
    			'msg' => '商品参数格式不正确'
    		]);
    	}

    	if (empty($values)) {
    		throw new ProductException([
    			'msg' => '商品不能为空'
    		]);
    	}

    	foreach ($values as $value) {
    		$this->checkProduct($value);
    	}

        return true;
    }

    private function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->batch()->check($value);
        if (!$result) {
            throw new ProductException([
                'msg' => '商品参数不能为空'
            ]);
        }
    }

    protected function checkExpress($values)
    {
        if (!is_array($values)) {
            throw new ExpressException([
                'msg' => '快递参数错误'
            ]);
        }

        if (!array_key_exists('express_name', $values) || !array_key_exists('express_price', $values)) {
            throw new ExpressException([
                'msg' => '快递参数错误'
            ]);
        }

        return true;
    }
}