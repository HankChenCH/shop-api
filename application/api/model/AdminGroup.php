<?php

namespace app\api\model;

class AdminGroup extends BaseModel
{
	protected $autoWriteTimestamp = false;

	protected $hidden = ['delete_time'];
}
