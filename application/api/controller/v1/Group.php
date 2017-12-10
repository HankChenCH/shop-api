<?php

namespace app\api\controller\v1;

use app\api\model\ChatGroup as GroupModel;
use app\api\service\Group as GroupService;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\GroupNew;
use app\api\validate\PagingParameterAdmin;
use app\lib\exception\GroupException;

class Group extends BaseController
{
	public function getList($name='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$groups = GroupModel::getAllBySearch(['name' => $name, 'create_time' => $createTime])
						->with('admins')
						->paginate($pageSize,false,['page' => $page]);
		
		if ($groups->isEmpty()) {
			throw new GroupException();
		}

		return $groups;
	}

	public function getMy()
	{
		$myGroups = GroupService::getMyGroups();

		if (!$myGroups) {
			throw new GroupException();
		}

		return $myGroups;
	}

	public function create()
	{
		$validate = new GroupNew();
		$validate->scene('create');
		$validate->goCheck();
	
		$data = $validate->getDataOnScene(input('post.'));
	
		$group = GroupModel::create($data);

		if(!$group) {
			throw new GroupException([
				'msg' => '群组创建失败'
			]);
		}

		return $group;
	}

	public function update($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new GroupNew();
		$validate->scene('update');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$group = GroupModel::where('id', $id)
				->update($data);

		if(!$group) {
			throw new GroupException([
				'msg' => '群组更新失败'
			]);
		}

		return $group;
	}
	
	public function remove($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$group = GroupModel::destroy($id);

		if(!$group) {
			throw new GroupException([
				'msg' => '群组删除失败'
			]);
		}

		return $group;
	}

	public function allotAdmin($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new GroupNew();
		$validate->scene('allot');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$group = GroupModel::with('admins')
				->find($id);

		if(!$group) {
			throw new GroupException();
		}

		if(count($group->admins) === 0) {
			$groupAdmin = GroupService::createAllot($data['admin_group'], $id);
		} else {
			$groupAdmin = GroupService::updateAllot($data['admin_group'], $id);
		}

		return $groupAdmin;
	}
}
