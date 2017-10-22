<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\validate\IDConllection;
use app\api\validate\OrderPlace;
use app\api\validate\OrderStatus;
use app\api\validate\OrderUpdate;
use app\api\validate\OrderIssue;
use app\api\validate\PagingParameterAdmin;
use app\api\validate\PagingParameter;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct as OrderProductModel;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;


class Order extends BaseController
{
	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'placeOrder'],
		'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
		'checkAdminScope' => ['only' => 'getSummaryByAdmin,updatePrice,delivery,removeOrder,batchRemoveOrder']
	];

	public function placeOrder()
	{
		/*
			下单接口
			1、参数校验，参数必须为数组，且数组内记录订单的产品ID和总数
			2、获得当前token的用户id
			3、根据下单的产品列表，获取当前产品状态、库存
			4、根据当前产品状态，生成订单状态（是否通过，总金额，总数，每件产品状态）
			5、订单不通过，则返回订单信息
			6、订单通过后，生成订单快照（以防产品和收货地址变动造成订单信息改变）
			7、根据订单快照，生成订单
			8、创建成功，返回订单id、订单号、创建时间
		*/
		(new OrderPlace())->goCheck();

		$products = input('post.orderProducts/a');
		$express = !empty(input('post.orderExpress/a')) ? input('post.orderExpress/a') : 0 ;
		$uid = TokenService::getCurrentUid();

		$order = new OrderService();
		$status = $order->place($uid,$products,$express);

		return $status;
	}

	public function getCountsByUser()
	{
		$uid = TokenService::getCurrentUid();
		$orders = OrderModel::where('user_id', $uid)
			->field("count(*),status")
			->group('status')
			->select();

		return $orders;
	}

	public function getSummaryByUser($page=1, $size=15)
	{
		(new PagingParameter())->goCheck();
		$uid = TokenService::getCurrentUid();

		$orders = OrderModel::getSummaryByUser($uid,$page,$size);
		if ($orders->isEmpty()) {
			return [
				'data' => [],
				'currentPage' => $orders->getCurrentPage()
			];
		}

		$data = $orders->hidden(['user_id','snap_items','snap_address','prepay_id'])->toArray();
		return [
			'data' => $data,
			'currentPage' => $orders->getCurrentPage()
		];
	}

	public function getSummaryByAdmin($status, $page=1, $pageSize=10)
	{
		(new OrderStatus())->goCheck();
		(new PagingParameterAdmin())->goCheck();

		$orders = OrderModel::with(['user'])
					->where('status','=',$status)
					->order('create_time desc')
					->paginate($pageSize,false,['page'=>$page]);

		if ($orders->isEmpty()) {
			throw new OrderException([
				'msg' => '该状态下暂无订单'
			]);
		}

		return $orders;
	}

	public function getTicketByBatchID($bid)
	{
		$tickets = OrderProductModel::where('batch_id', $bid)
					->with('order')
					->with('order.user')
					->select();

		if ($tickets->isEmpty()) {
			throw new OrderException([
				'msg' => '该抢购暂未出票'	
			]);
		}

		return $tickets;
	}

	public function getDetail($id)
	{
		(new IDMustBePostiveInt())->goCheck();
		$uid = TokenService::getCurrentUid();

		$orderDetail = OrderModel::get($id);

		if (!$orderDetail || $orderDetail->user_id != $uid) {
			throw new OrderException();
		}

		return $orderDetail->hidden(['prepay_id']);
	}

	public function getDetailByAdmin($id)
	{
		(new IDMustBePostiveInt())->goCheck();
	
		$orderDetail = OrderModel::with(['user','logs'])
			->find($id);

		if (!$orderDetail) {
			throw new OrderException();
		}

		return $orderDetail;
	}

	public function getBuyNowByUser($bid)
	{
		$uid = TokenService::getCurrentUid();

		// $buyNowOrders = OrderProductModel::where('batch_id', $bid)
		// 					->with('order')
		// 					->select();

		// foreach ($buyNowOrders as $key => $value) {
		// 	if ($value->order->user_id == $uid) {
		// 		return true;
		// 	}
		// }

		// return false;

		return OrderService::checkHasBuy($uid, [$bid]);
	}

	public function updatePrice($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new OrderUpdate();
		$validate->scene('changePrice');
		$validate->goCheck();

		$nickName = TokenService::getCurrentNickName();

		$data = $validate->getDataOnScene(input('put.'));

		$order = OrderService::changePrice($data,$nickName,$id);

		if (!$order) {
			throw new OrderException();
		}

		return $order;
	}

	public function closeOrders($ids)
	{
		(new IDConllection)->goCheck();

		$ids = explode(',',$ids);

		$orders = OrderModel::closeOrders($ids);

		if (!$orders) {
			throw new OrderException([
				'msg' => '关闭订单失败',
			]);
		}

		return $orders;
	}

	public function removeOrder($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$order = OrderModel::destroy($id);

		if (!$order) {
			throw new OrderException([
				'msg' => '删除订单失败'
			]);
		}

		return $order;
	}

	public function batchRemoveOrder()
	{
		(new IDConllection())->goCheck();

		$ids = input('delete.ids');
		$orders = OrderModel::destroy($ids);

		if (!$orders) {
			throw new OrderException([
				'msg' => '批量删除订单失败'
			]);
		}

		return $orders;
	}

	public function delivery($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new OrderUpdate();
		$validate->scene('delivery');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$order = new OrderService();
		$success = $order->delivery($id, $data);
		if ($success) {
			return new SuccessMessage();
		}
	}

	public function issue($id)
	{
		(new IDMustBePostiveInt)->goCheck();

		$validate = new OrderIssue();
		$validate->scene('issue');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$order = new OrderService();
		$success = $order->issue($id, $data);
		if ($success) {
			return new SuccessMessage();
		}

		return $data;
	}
}
