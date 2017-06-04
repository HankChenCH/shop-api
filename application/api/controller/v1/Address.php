<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;

class Address extends BaseController
{
	protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
	];

	public function createOrUpdateAddress()
	{
 		$validate = new AddressNew();
 		$validate->scene('createAndUpdate');
 		$validate->goCheck();

 		$uid = TokenService::getCurrentUid();

 		$user = UserModel::get($uid);

 		if (!$user) {
 			throw new UserException();
 		}

 		$data = $validate->getDataOnScene(input('post.'));
 		$userAddress = $user->address;

 		if (!$userAddress) {
 			$user->address()->save($data);
 		}else{
 			$user->address->save($data);
 		}

 		return json(new SuccessMessage(),201);
	}
}