<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\AdminNew;
use app\api\validate\AdminProfileNew;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\IDConllection;
use app\api\validate\PagingParameterAdmin;
use app\api\model\Admin as AdminModel;
use app\api\service\Admin as AdminService;
use app\lib\exception\AdminException;

class Admin extends BaseController
{
	public function getAll($truename='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$admins = AdminModel::getAllBySearch(['true_name' => $truename, 'create_time' => $createTime])
						->with(['profile', 'roles'])
						->paginate($pageSize,false,['page' => $page]);

		if ($admins->isEmpty()) {
			throw new AdminException();
		}

		return $admins;
	}

	public function getOne($id)
	{
	    (new IDMustBePostiveInt())->goCheck();
	    
	    $admin = AdminModel::with(['profile', 'roles'])
					->where('state',1)
	                ->find($id);

	    if(!$admin) {
	    	throw new AdminException();
	    }

	    return $admin;
	}

	public function authRole($id)
	{
	    (new IDMustBePostiveInt())->goCheck();

	    $validate = new AdminNew();
	    $validate->scene('authRole');
	    $validate->goCheck();

	    $data = $validate->getDataOnScene(input('put.'));	    

	    $admin = AdminModel::with('roles')
			->find($id);

	    if (!$admin) {
	        throw new AdminException([
		    'msg' => '授权失败，管理员不存在'
		]);
	    }

	    if (count($admin->roles) === 0) {
	        $adminRoles = AdminService::createAuth($data['admin_role'], $id);
	    } else {
	    	$adminRoles = AdminService::updateAuth($data['admin_role'], $id);
	    }

	    return $adminRoles;
	}

	public function getChatMember()
	{
		return AdminModel::where(['state' => '1'])
				->select();
	}

	public function createAdmin()
	{
		$baseInfoValidate = new AdminNew();
		$baseInfoValidate->scene('create');
		$baseInfoValidate->goCheck();

		$profileInfoValidate = new AdminProfileNew();
		$profileInfoValidate->scene('create');
		$profileInfoValidate->goCheck();

		$baseInfoData = $baseInfoValidate->getDataOnScene(input('post.'));
		$profileInfoData = $profileInfoValidate->getDataOnScene(input('post.'));

		$baseInfoData['password'] = md5($baseInfoData['password']);
		unset($baseInfoData['repassword']);

		$data = $baseInfoData;
		$data['profile'] = $profileInfoData;

		$admin = AdminService::create($data);

		return $admin; 
	}

	public function updateAdmin($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$baseInfoValidate = new AdminNew();
		$baseInfoValidate->scene('update');
		$baseInfoValidate->goCheck();

		$profileInfoValidate = new AdminProfileNew();
		$profileInfoValidate->scene('update');
		$profileInfoValidate->goCheck();

		$baseInfoData = $baseInfoValidate->getDataOnScene(input('post.'));
		$profileInfoData = $profileInfoValidate->getDataOnScene(input('post.'));

		if (array_key_exists('password', $baseInfoData)) {
			$baseInfoData['password'] = md5($baseInfoData['password']);
			unset($baseInfoData['repassword']);
		}

		$data = $baseInfoData;
		$data['profile'] = $profileInfoData;

		$admin = AdminService::update($id, $data);

		return $admin; 

	}

	public function disOrEnable($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new AdminNew();
		$validate->scene('updateStatus');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$admin = AdminModel::get($id)
					->save($data);

		if (!$admin) {
			throw new AdminException([
				'msg' => '更新管理员状态失败'
			]);
		}

		return $admin;
	}

	public function batchUpdate()
	{
		(new IDConllection())->goCheck();

		$ids = input('put.ids');

		$validate = new AdminNew();
		$validate->scene('updateStatus');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));

		$admins = AdminModel::batchUpdate($ids, $data);

		if ($admins->isEmpty()) {
			throw new AdminException([
				'msg' => '批量' . $data['state'] === "1" ? '启用' : '禁用' . '失败'
			]);
		}

		return $admins;
	}

	public function removeAdmin($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$admin = AdminModel::destroy($id);

		if (!$admin) {
			throw new AdminException([
				'msg' => '删除管理员失败'
			]);
		}

		return $admin;
	}

	public function batchRemoveAdmin()
	{
		(new IDConllection())->goCheck();

		$ids = input('delete.ids');

		$admins = AdminModel::destroy($ids);

		if (!$admins) {
			throw new AdminException([
				'msg' => '批量删除管理员失败'
			]);
		}

		return $admins;
	}
}
