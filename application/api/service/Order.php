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
use app\api\model\ProductBuyNow;
use app\lib\exception\OrderException;
use app\lib\enum\TypeEnum;
use app\lib\enum\OrderStatusEnum;
use app\lib\enum\OrderTypeEnum;
use app\lib\enum\OrderLogTypeEnum;
use think\Log;
use think\Db;

class Order
{
	protected $oProducts;

	protected $oExpress;

	protected $products;

	protected $uid;

	public function place($uid, $oProducts, $oExpress = 0)
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
        $this->oExpress = $this->toArray($order->snap_express);
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
			$order->type = $snap['type'];

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

		$orderSn = str_replace(' ', rand(0, 9), $orderSn);

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
			'type' => OrderTypeEnum::NORMAL,
		];

		$snap['orderPrice'] = $status['orderPrice'] + $this->oExpress['express_price'];
		$snap['totalCount'] = $status['totalCount'];
		$snap['pStatus'] = $status['pStatusArray'];
		$snap['snapAddress'] = json_encode($this->getUserAddress());
		$snap['snapName'] = $this->products[0]['name'];
		$snap['snapImg'] = $this->products[0]['main_img_url'];
		$snap['snapExpress'] = json_encode($this->oExpress);
		$snap['type'] = $status['type'];

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
			'type' => TypeEnum::ENTITY,
			'orderPrice' => 0,
			'expressPrice' => 0,
			'totalCount' => 0,
			'pStatusArray' => []
		];

		foreach ($this->oProducts as $oProduct) {
			$pStatus = $this->getProductStatus($oProduct,$this->products);

			if (!$pStatus['haveStock']) {
				$status['pass'] = false;
			}

			if ($pStatus['type'] == TypeEnum::COUPON) {
				$status['type'] = TypeEnum::COUPON;
			}

			$status['orderPrice'] += $pStatus['totalPrice'];
			$status['totalCount'] += $pStatus['counts'];
			array_push($status['pStatusArray'], $pStatus); 
		}

		if ($this->oExpress) {
			$status['expressPrice'] += $this->oExpress['express_price'];
		}

		return $status;
	}

	private function getProductStatus($oProduct,$products)
	{
		$pIndex = -1;
		$oPID = $oProduct['product_id'];
		$oCount = $oProduct['count'];

		$pStatus = [
			'id' => null,
			'haveStock' => false,
			'counts' => 0,
			'type' => TypeEnum::ENTITY,
			'price' => null,
			'main_img_url' => null,
			'name' => '',
			'totalPrice' => 0,
			'batch_no' => null,
			'batch_id' => 0,
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
			$pStatus['type'] = $product['type'];
			$pStatus['totalPrice'] = $pStatus['price'] * $oCount;

			if (isset($product['buy_now'])) {
				$now = time();
				if ($product['buy_now'][0]['stock'] - $oCount >= 0 
					&& $product['buy_now'][0]['start_time'] < $now
					&& $product['buy_now'][0]['end_time'] > $now) {
					$pStatus['haveStock'] = true;
				}
				$pStatus['price'] = $product['buy_now'][0]['price'];
				$pStatus['totalPrice'] = $pStatus['price'] * $oCount;
				$pStatus['batch_no'] = $product['buy_now'][0]['batch_no'];
				$pStatus['batch_id'] = $product['buy_now'][0]['id'];
			} else {
				if ($product['stock'] - $oCount >= 0) {
					$pStatus['haveStock'] = true;
				}
			}

		}

		return $pStatus;
	}

	private function getProductsByOrder()
	{
		$oPids = [];
		$oBatchID = [];
		foreach ($this->oProducts as $oProduct) {
			array_push($oPids, $oProduct['product_id']);

			if (isset($oProduct['batch_id']) && !empty($oProduct['batch_id'])) {
				array_push($oBatchID, $oProduct['batch_id']);
			}
		}

		if (count($oBatchID) > 0) {
			$products = Product::with(['buyNow' => function ($query) use ($oBatchID){
					$query->where('id', 'in', $oBatchID);
				}])
				->select($oPids)
				->visible(['id','name','price','stock','main_img_url','type', 'buy_now'])
				->toArray();
		} else {
			$products = Product::all($oPids)
				->visible(['id','name','price','stock','main_img_url','type'])
				->toArray();
		}

		return $products;
	}

	public function delivery($orderID, $orderData, $jumpPage = '')
	{
		$order = OrderModel::get($orderID);

		if (!$order) {
			throw new OrderException();
		}

		if ($order->status != OrderStatusEnum::PAID) {
			throw new OrderException([
				'msg' => '订单状态异常，不能发货',
				'errorCode' => 80002,
				'code' => 403	
			]);
		}

		$order->status = OrderStatusEnum::DELIVERED;
		$order->snap_express = $this->makeSnapExpressInfo($orderData,$order->snap_express);
		$order->delivery_time = time();
		
		$order->save();

		$message = new DeliveryMessage();
		return $message->send($order, $jumpPage);
	}

	private function makeSnapExpressInfo($newData, $oldData)
	{
		$expressData = array();

		if (array_key_exists('express_name', $newData)) {
			$expressData['express_name'] = $newData['express_name'];
		}

		if (array_key_exists('express_no', $newData)) {
			$expressData['express_no'] = $newData['express_no'];
		}

		if (!empty($oldData)) {
			$expressData['express_price'] = $oldData->express_price;
		}

		return json_encode($expressData);
	}

	public function issue($orderID, $orderItemData, $jumpPage = '')
	{
		$order = OrderModel::get($orderID);

		if (!$order) {
			throw new OrderException();
		}

		if ($order->status != OrderStatusEnum::PAID) {
			throw new OrderException([
				'msg' => '订单状态异常，不能出票',
				'errorCode' => 80005,
				'code' => 403	
			]);
		}

		$order->status = OrderStatusEnum::DELIVERED;
		$order->snap_items = $this->issueTicketToItem($orderItemData,$order->snap_items);
		$order->delivery_time = time();

		$order->save();

		$message = new IssueMessage();
		return $message->send($order, $jumpPage);
	}

	public function issueTicketToItem($orderItemData, $oldData)
	{

		foreach ($oldData as $key => &$value) {
			$value->ticket = $orderItemData['tickets'][$value->id]['ticket'];
		}

		return json_encode($oldData);
	}

	private function toArray($obj)
	{
		if (is_array($obj)) {
			return $obj;
		}

		$objStr = json_encode($obj);

		return json_decode($objStr, true);
	}
}