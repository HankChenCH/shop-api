<?php

namespace app\api\model;

class BaseRedis
{
	protected static $redis_instance = null;
	protected static $server_ip = '127.0.0.1';
	protected static $port = 6397;

	public static function getRedis()
	{
		if (is_null(self::$redis_instance)) {
			self::$redis_instance = new \Redis();
			self::$redis_instance->connect(self::$server_ip);
		}

		return self::$redis_instance;
	}
}
