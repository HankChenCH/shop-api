<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\AdminNew;
use app\api\model\Admin as AdminModel;
use app\lib\exception\AdminException;

class Admin extends BaseController
{
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