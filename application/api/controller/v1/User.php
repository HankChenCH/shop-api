<?php

namespace app\api\controller\v1;

use app\api\validate\WxInfo;
use app\api\validate\PagingParameterAdmin;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

class User extends BaseController
{
	public function getAll($nickname='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$users = UserModel::getAllBySearch(['nickname' => $nickname, 'create_time' => $createTime])
						->paginate($pageSize,false,['page' => $page]);

		if ($users->isEmpty()) {
			throw new UserException();
		}

		return $users;
	}

	public function updateWxInfo()
	{
		$validate = new WxInfo();
		$validate->scene('updateInfo');
		$validate->gocheck();

		$uid = TokenService::getCurrentUid();

		if (empty($uid)) {
			throw new TokenException();
		}

		$data = $validate->getDataOnScene(input('post.'));
		$user = UserModel::get($uid);

		if (!$user) {
			throw new UserException();
		}

		$user->save($data);

		return $uid;
	}

}