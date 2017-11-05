<?php

namespace app\api\service;

interface GrantToken
{
	public function grantJWT($userInfo);
	public function grantCache($userInfo);
}
