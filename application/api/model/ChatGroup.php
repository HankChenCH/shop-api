<?php

namespace app\api\model;

class ChatGroup extends BaseModel
{
	protected $hidden = ['update_time', 'delete_time', 'pivot'];

	public function admins()
	{
		return $this->belongsToMany('Admin', 'AdminGroup', 'admin_id', 'group_id');
	}
}
