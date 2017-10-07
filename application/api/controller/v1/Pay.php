<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/6/11
 * Time: 20:08
 */

namespace app\api\controller\v1;

use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id='', $bid='')
    {
        /*
			请求微信的预订单接口，生成预订单信息返回给小程序拉起支付
			1、参数校验，传来的订单id必须为正整数
			2、业务验证，验证是否存在该订单、订单是否属于该用户、订单状态是否为未支付
			3、检查库存量
			4、调用微信SDK，配置生成预订单所需的信息（订单号，总金额，商户名，用户openid，异步通知支付结果地址，交易类型）
			5、调用SDK中的API，取得预订单生成结果
			6、如果失败，则记录日志
			7、将生成的预订单id保存至相应的订单记录中
			8、配置数据，生成小程序拉起支付所需的参数（调用WxJsApiPay SDK）
			9、将生成的参数返回给小程序
        */
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id, $bid);
        return $pay->pay();
    }

    public function receiveWxNotify()
    {
        $WxNotify = new WxNotify();
        return $WxNotify->Handle();
    }
}