<?php

namespace app\api\controller\v1;

use app\api\validate\WxInfo;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;

class User extends BaseController
{
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

		$user->save($data);

		return $uid;
	}
}