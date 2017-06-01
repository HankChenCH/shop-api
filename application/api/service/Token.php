<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;


class Token
{
	public static function generateToken()
	{
		$randChars = getRandChars(32);
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		$salt = config('secure.token_salt');

		$tokenArr = [$randChars,$timestamp,$salt];
		sort($tokenArr);
		$token = implode('', $tokenArr);

		return md5($token);
	}
}