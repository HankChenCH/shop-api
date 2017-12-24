<?php

namespace app\api\controller\v1;

use app\api\validate\PagingParameterAdmin;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\RoleNew;
use app\api\model\Admin as AdminModel;
use app\api\model\Role as RoleModel;
use app\api\service\Token;
use app\api\service\Auth;
use app\api\service\Role as RoleService;
use app\lib\exception\RoleException;
use app\lib\exception\AdminException;

class Role extends BaseController
{
	public function getList($name="", $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$roles = RoleModel::getAllBySearch(['name' => $name])
						->with('resources')
						->paginate($pageSize,false,['page' => $page]);

		if ($roles->isEmpty()) {
			throw new RoleException();
		}

		return $roles;
	}

	public function getMy()
	{
		$uid = Token::getCurrentUid();

		$admin = AdminModel::get($uid, ['roles']);

		if(!$admin) {
			throw new AdminException();
		}

		$userRole = Auth::getUserRole($admin);
		
		return $userRole;
	}

	public function getAll()
	{
	    $roles = RoleModel::all();

	    if($roles->isEmpty()){
	        throw new RoleException();
	    }

	    return $roles;
	}

	public function create()
	{
		$validate = new RoleNew();
		$validate->scene('create');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$role = RoleService::create($data);

		return $role;
	}

	public function update($id)
	{
		(new IDMustBePostiveInt())->goCheck();
		$validate = new RoleNew();
		$validate->scene('update');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$role = RoleService::update($data, $id);

		return $role;
	}

	public function remove($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$role = RoleService::remove($id);

		if (!$role) {
			throw new RoleException([
				'msg' => '删除角色失败'
			]);
		}

		return $role;
	}

	public function batchRemove($ids)
	{

	}
}
