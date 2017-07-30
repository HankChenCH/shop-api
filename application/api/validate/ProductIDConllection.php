<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:20
 */

namespace app\api\validate;


class ProductIDConllection extends BaseValidate
{
    protected $rule = [
        'product_id' => 'require|checkIDs'
    ];

    protected $message = [
        'product_id' => 'ids必须是以逗号分隔的正整数'
    ];
}