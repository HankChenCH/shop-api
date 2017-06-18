<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'placeOrder'],
		'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser']
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

		$products = input('post.products/a');
		$uid = TokenService::getCurrentUid();

		$order = new OrderService();
		$status = $order->place($uid,$products);

		return $status;
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

		$data = $orders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
		return [
			'data' => $data,
			'currentPage' => $orders->getCurrentPage()
		];
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
}