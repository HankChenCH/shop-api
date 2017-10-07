<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\api\model\Express as ExpressModel;
use app\lib\exception\ExpressException;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\IDConllection;
use app\api\validate\ExpressInfo;


class Express extends BaseController
{
	
	public function getSetting()
	{
		return [
			'express_price' => config('setting.express_price'),
			'express_limit' => config('setting.express_limit'),
		];
	}

	public function getAll()
	{
		$expresses = ExpressModel::all();

		if ($expresses->isEmpty()) {
			throw new ExpressException();
		}

		return $expresses;
	}

	public function addExpress()
	{
		$validate = new ExpressInfo();
		$validate->scene('create');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$express = ExpressModel::create($data);

		if (!$express) {
			throw new ExpressException([
				'msg' => '创建快递信息失败'
			]);
		}

		return $express;
	}

	public function updateExpress($id)
	{	
		(new IDMustBePostiveInt)->goCheck();

		$validate = new ExpressInfo();
		$validate->scene('update');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$express = ExpressModel::find($id);

		$express->save($data);

		if (!$express) {
			throw new ExpressException([
				'msg' => '更新快递信息失败'
			]);
		}

		return $express;
	}

	public function removeExpress($id)
	{
		(new IDMustBePostiveInt)->goCheck();

		$express = ExpressModel::destroy($id);

		if (!$express) {
			throw new ExpressException([
				'msg' => '删除快递信息失败'
			]);
		}

		return $express;
	}

	public function batchRemoveExpress($ids)
	{
		(new IDConllection)->goCheck();

		$expresses = ExpressModel::destroy($ids);

		if (!$expresses) {
			throw new ExpressException([
				'msg' => '批量删除快递信息失败'
			]);
		}

		return $expresses;
	}
}