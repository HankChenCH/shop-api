<?php

namespace app\api\model;

class BaseRadis;
{
	protected $radis_instance = null;
	protected $server_ip = '127.0.0.1';
	protected $port = 6397;

	public function getRadis ()
	{
		if (is_null(self::$radis_instance)) {
			self::$radis_instance = new \Radis();
			self::$radis_instance->connect(self::$server_ip);
		}

		return self::$radis_instance;
	}
}
