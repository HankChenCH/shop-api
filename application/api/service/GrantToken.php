<?php

namespace app\api\service;

interface GrantToken
{
	private function grantJWT($userInfo);
	private function granteCache($userInfo);
}