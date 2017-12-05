<?php

namespace app\api\behavior;

use app\api\service\Auth as AuthService;

class Auth
{
	public function run(&$params)
	{
		AuthService::checkAuth($params);
	}
}
