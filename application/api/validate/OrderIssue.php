<?php

namespace app\api\validate;

use app\lib\exception\OrderException;

class OrderIssue extends BaseValidate
{
	protected $rule = [
		'tickets' => 'require|checkTickets',
	];

	protected $scene = [
        'issue' => ['tickets'],
	];

	protected $singleRule = [
		'ticket' => 'require|isNotArrayEmpty',
	];

	protected function checkTickets($values)
    {
    	if (!is_array($values)) {
    		throw new ProductException([
    			'msg' => '票据参数格式不正确'
    		]);
    	}

    	if (empty($values)) {
    		throw new OrderException([
    			'msg' => '票据不能为空'
    		]);
    	}

    	foreach ($values as $value) {
    		$this->checkTicket($value);
    	}

        return true;
    }

    private function checkTicket($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->batch()->check($value);
        if (!$result) {
            throw new OrderException([
                'msg' => '票据参数不能为空'
            ]);
        }
    }
}