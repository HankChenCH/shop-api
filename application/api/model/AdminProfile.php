<?php

namespace app\api\model;

class AdminProfile extends BaseModel
{
	protected $hidden = ['admin_id','create_time','update_time','delete_time'];
}