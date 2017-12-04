<?php

namespace app\api\model;

class Role extends BaseModel
{
	protected $hidden = ['update_time', 'delete_time'];

	public function resources()
	{
		// return $this->hasMany('RoleResource','resource_id','id');
		return $this->belongsToMany('Resources','role_resource','resource_id','role_id');
	}
}