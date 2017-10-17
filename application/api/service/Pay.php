<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/6/11
 * Time: 20:15
 */

namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use app\lib\exception\WxException;
use app\lib\enum\OrderStatusEnum;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    public function __construct($orderID)
    {
        if (!$orderID){
            throw new Exception('订单号不允许为空');
        }

        $this->orderID = $orderID;
    }

    public function pay()
    {
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {

            if ($status['hasBuyNow']) {
                OrderModel::destroy($this->orderID);
            }

            return $status;
        }

        //直接使用订单价格
        $order = OrderModel::where('id','=',$this->orderID)->find();

        $orderPrice = !empty($order['discount_price']) ? 
                    $order['discount_price'] : 
                    $status['orderPrice'] + $status['expressPrice'];

        return $this->makeWxPreOrder($orderPrice);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }

        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody(config('wx.shop_name'));
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.pay_callback'));

        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);

        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
            throw new WxException();
        }

        $this->reacordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);

        return $signature;
    }

    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }

    private function reacordPreOrder($wxOrder)
    {
        OrderModel::where('id','=',$this->orderID)
            ->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if (!$order){
            throw new OrderException();
        }

        if (!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }

        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已支付'
            ]);
        }

        $this->orderNO = $order->order_no;

        return true;
    }
}