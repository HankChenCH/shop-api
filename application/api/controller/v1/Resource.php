<?php

namespace app\api\controller\v1;

use app\api\validate\PagingParameterAdmin;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\ResourceNew;
use app\api\model\Resource as ResourceModel;
use app\lib\exception\ResourceException;

class Resource extends BaseController
{
	public function getList($name='', $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$resources = ResourceModel::getAllBySearch(['name' => $name])
						->order('resource_type asc')
						->paginate($pageSize,false,['page' => $page]);

		if ($resources->isEmpty()) {
			throw new ResourceException();
		}

		return $resources;
	}

	public function getAll()
	{
		$resources = ResourceModel::all();

		if ($resources->isEmpty()) {
			throw new ResourceException();
		}

		return $resources;
	}

	public function getOne($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$resource = ResourceModel::get($id);

		if (!$resource) {
			throw new ResourceException();
		}

		return $resource;
	}

	public function create()
	{
		$validate = new ResourceNew();
		$validate->scene('create');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$resource = ResourceModel::create($data);

		if (!$resource) {
			throw new ResourceException([
				'msg' => '资源权限创建失败'
			]);
		}

		return $resource;
	}

	public function update($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new ResourceNew();
		$validate->scene('update');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$resource = ResourceModel::save($data, ['id' => $id]);

		if (!$resource) {
			throw new ResourceException([
				'msg' => '资源权限更新失败'
			]);
		}

		return $resource;
	}

	public function remove($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$resource = ResourceModel::destory($id);

		if (!$resource) {
			throw new ResourceException([
				'msg' => '资源权限删除失败'
			]);
		}

		return $resource;
	}
}