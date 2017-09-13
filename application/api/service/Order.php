<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use app\api\model\Product;
use app\api\model\Order as OrderModel;
use app\api\model\OrderLog as OrderLogModel;
use app\api\model\UserAddress;
use app\api\model\OrderProduct;
use app\lib\exception\OrderException;
use app\lib\enum\OrderLogTypeEnum;
use think\Log;
use think\Db;

class Order
{
	protected $oProducts;

	protected $oExpress;

	protected $products;

	protected $uid;

	public function place($uid, $oProducts, $oExpress)
	{
		$this->oProducts = $oProducts;
		$this->oExpress = $oExpress;
		$this->products = $this->getProductsByOrder();
		$this->uid = $uid;

		$status = $this->getOrderStatus();

		if (!$status['pass']) {
			$status['order_id'] = -1;
			return $status;
		}

		// var_dump($status);
		// exit();

		//开始创建订单
		$orderSnap = $this->snapOrder($status);
		$order = $this->createOrder($orderSnap);
		$order['pass'] = true;

		return $order;
	}

	public function checkOrderStock($orderID)
    {
        $oProducts = OrderProduct::where('order_id','=',$orderID)->select();
        $order = OrderModel::where('id','=',$orderID)->find();
        $this->oProducts = $oProducts;
        $expressInfo = json_decode($order->snap_express,true);
        $this->oExpress = $expressInfo['express_price'];
        $this->products = $this->getProductsByOrder();

        $status = $this->getOrderStatus();
        return $status;
    }

    public static function changePrice($data, $nickName, $id)
    {
    	Db::startTrans();

    	try{
	    	$order = OrderModel::get($id)
	    				->allowField(true)
	    				->save($data);

	    	$orderLog = OrderLogModel::create([
	    		'order_id' => $id,
	    		'type' => OrderLogTypeEnum::CHANGEPRICE,
	    		'log' => $nickName . '于' . date('Y-m-d H:i:s') . '更改订单价格为：' . $data['discount_price'] . '元',
	    		'reason' => $data['reason']
	    	]);

	    	Db::commit();
	    	return $order;
    	}catch(\Exception $e){
    		Db::rollback();
    		Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');
			throw new OrderException([
				'msg' => '订单价格修改失败'
			]);
    	}
    }

	private function createOrder($snap)
	{
		try{
			$orderNo = self::makeOrderNo();
			$order = new OrderModel();
			$order->user_id = $this->uid;
			$order->order_no = $orderNo;
			$order->total_price = $snap['orderPrice'];
			$order->total_count = $snap['totalCount'];
			$order->snap_img = $snap['snapImg'];
			$order->snap_name = $snap['snapName'];
			$order->snap_address = $snap['snapAddress'];
			$order->snap_express = $snap['snapExpress'];
			$order->snap_items = json_encode($snap['pStatus']);

			$order->save();

			$orderID = $order->id;
			$create_time = $order->create_time;
			foreach ($this->oProducts as &$p) {
				$p['order_id'] = $orderID;
			}

			$orderProduct = new OrderProduct();
			$orderProduct->saveAll($this->oProducts);

			return [
				'order_no' => $orderNo,
				'order_id' => $orderID,
				'create_time' => $create_time
			];
		}catch(Exception $e){
			throw $e;
		}
	}

	public static function makeOrderNo()
	{
		$yCode = array('A','B','C','D','E','F','G','H','I','J');
		$orderSn = $yCode[intval( date('Y') - 2017 )] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%2d', rand(0, 99));

		return $orderSn;
	}

	private function snapOrder($status)
	{
		$snap = [
			'orderPrice' => 0,
			'totalCount' => 0,
			'pStatus' => [],
			'snapAddress' => null,
			'snapName' => '',
			'snapImg' => '',
			'snapExpress' => '',
		];

		$snap['orderPrice'] = $status['orderPrice'] + $this->oExpress;
		$snap['totalCount'] = $status['totalCount'];
		$snap['pStatus'] = $status['pStatusArray'];
		$snap['snapAddress'] = json_encode($this->getUserAddress());
		$snap['snapName'] = $this->products[0]['name'];
		$snap['snapImg'] = $this->products[0]['main_img_url'];
		$snap['snapExpress'] = json_encode(['express_price' => $this->oExpress]);

		if (count($this->products) > 1) {
			$snap['snapName'] .= '等';
		}

		return $snap;
	}

	private function getUserAddress()
	{
		$userAddress = UserAddress::where('user_id','=',$this->uid)
			->find();

		if (!$userAddress) {
			throw new OrderException([
				'msg' => '用户收货地址不存在，下单失败',
				'errorCode' => 60001
			]);
		}

		return $userAddress->toArray();
	}

	private function getOrderStatus()
	{
		$status = [
			'pass' => true,
			'orderPrice' => 0,
			'expressPrice' => 0,
			'totalCount' => 0,
			'pStatusArray' => []
		];

		foreach ($this->oProducts as $oProduct) {
			$pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);

			if (!$pStatus['haveStock']) {
				$status['pass'] = false;
			}

			$status['orderPrice'] += $pStatus['totalPrice'];
			$status['totalCount'] += $pStatus['counts'];
			array_push($status['pStatusArray'], $pStatus); 
		}

		if ($this->oExpress) {
			// $status['orderPrice'] += $this->oExpress;
			$status['expressPrice'] += $this->oExpress;
		}

		return $status;
	}

	private function getProductStatus($oPID,$oCount,$products)
	{
		$pIndex = -1;

		$pStatus = [
			'id' => null,
			'haveStock' => false,
			'counts' => 0,
			'price' => null,
			'main_img_url' => null,
			'name' => '',
			'totalPrice' => 0
		];

		for ($i=0; $i < count($products); $i++) { 
			if ($oPID === $products[$i]['id']) {
				$pIndex = $i;
			}
		}

		if ($pIndex === -1) {
			throw new OrderException([
				'msg' => 'id为'.$oPID.'商品不存在，订单创建失败'
			]);
		}else{
			$product = $products[$pIndex];
			$pStatus['id'] = $product['id'];
			$pStatus['name'] = $product['name'];
			$pStatus['counts'] = $oCount;
			$pStatus['price'] = $product['price'];
			$pStatus['main_img_url'] = $product['main_img_url'];
			$pStatus['totalPrice'] = $product['price'] * $oCount;

			if ($product['stock'] - $oCount >= 0) {
				$pStatus['haveStock'] = true;
			}
		}

		return $pStatus;
	}

	private function getProductsByOrder()
	{
		$oPids = [];
		foreach ($this->oProducts as $oProduct) {
			array_push($oPids, $oProduct['product_id']);
		}

		$products = Product::all($oPids)
			->visible(['id','name','price','stock','main_img_url'])
			->toArray();

		return $products;
	}
}