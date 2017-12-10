<?php

namespace app\api\model;

class ChatMessage extends BaseModel
{
	protected $hidden = ['update_time', 'delete_time'];

	public function sender()
	{
		return $this->belongsTo('Admin', 'from_id', 'id');
	}
}