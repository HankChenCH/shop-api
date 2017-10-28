<?php

namespace app\api\model;

class BaseRedis
{
	protected static $redis_instance = null;
	protected static $server_ip = '127.0.0.1';
	protected static $port = 6397;

	protected $keyPrefix = 'base_';
	protected $dataPrefix;
	protected $keyID;

	public static function getRedis()
	{
		if (is_null(self::$redis_instance)) {
			self::$redis_instance = new \Redis();
			self::$redis_instance->connect(self::$server_ip);
		}

		return self::$redis_instance;
	}

	public function cacheData($data, $liveTime = 600)
	{
		$redis = self::getRedis();
		
		return $redis->setEx($this->dataPrefix . $this->keyID, $liveTime, serialize($data));
	}

	public function getData($keyID)
	{
		$redis = self::getRedis();

		$data = $redis->get($this->dataPrefix . $keyID);

		if (!$data) {
			return false;
		}

		$dataObj = unserialize($data);

		return $dataObj;
	}
}
