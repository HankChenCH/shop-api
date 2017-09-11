<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\AdminNew;
use app\api\validate\PagingParameterAdmin;
use app\api\model\Admin as AdminModel;
use app\lib\exception\AdminException;

class Admin extends BaseController
{
	public function getAll($truename='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$admins = (new AdminModel())->getAllBySearch(['true_name' => $truename, 'create_time' => $createTime])
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
}