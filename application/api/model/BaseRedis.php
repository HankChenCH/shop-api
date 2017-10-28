<?php

namespace app\api\model;

class BaseRedis
{
	protected static $redis_instance = null;
	protected static $server_ip = '127.0.0.1';
	protected static $port = 6397;

	protected static $self_instance = null;

	protected $keyPrefix = 'base_';
	protected $dataPrefix;
	protected $keyID;

	public function __construct()
	{
		self::$self_instance = $this;
		$this->dataPrefix = $this->keyPrefix . 'data:';
	}

	public static function getRedis()
	{
		if (is_null(self::$redis_instance)) {
			self::$redis_instance = new \Redis();
			self::$redis_instance->connect(self::$server_ip);
		}

		if (is_null(self::$self_instance)) {
			self::$self_instance = new self();
		}

		return self::$redis_instance;
	}

	public function cacheData($data, $liveTime = 600)
	{
		$redis = self::getRedis();

		return $redis->setEx($this->$dataPrefix . $this->keyID, $liveTime, serialize($data));
	}

	public static function getData($keyID)
	{
		$redis = self::getRedis();

		$data = $redis->get($this->$dataPrefix . $keyID);

		if (!$data) {
			return false;
		}

		$dataObj = unserialize($data);

		return $dataObj;
	}
}
