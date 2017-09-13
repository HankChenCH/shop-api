<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\AdminNew;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\IDConllection;
use app\api\validate\PagingParameterAdmin;
use app\api\model\Admin as AdminModel;
use app\lib\exception\AdminException;

class Admin extends BaseController
{
	public function getAll($truename='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$admins = AdminModel::getAllBySearch(['true_name' => $truename, 'create_time' => $createTime])
						->paginate($pageSize,false,['page' => $page]);

		if ($admins->isEmpty()) {
			throw new ProductException();
		}

		return $admins;
	}

	public function createAdmin()
	{
		$validate = new AdminNew();
		$validate->scene('create');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$data['password'] = md5($data['password']);
		unset($data['repassword']);

		$admin = AdminModel::create($data);

		if (!$admin) {
			throw new AdminException();
		}

		return $admin; 
	}

	public function updateAdmin()
	{


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