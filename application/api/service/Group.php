<?php

namespace app\api\service;

use app\api\model\ChatGroup as GroupModel;
use app\api\model\AdminGroup as AdminGroupModel;
use app\lib\exception\GroupException;

class Group
{
	public static function createAllot($data, $id)
	{
		$allude = AdminGroupModel::processAllude(['admin_id' => $data, 'group_id' => $id], 'group_id');
		
		$adminGroup = new AdminGroupModel();

		$adminGroup->saveAll($allude);

		if (!$adminGroup) {
			throw new GroupException([
				'msg' => '群组成员分配失败'
			]); 
		}

		return $adminGroup;
	}

	public static function updateAllot($data, $id)
	{
		$allude = AdminGroupModel::processAllude(['admin_id' => $data, 'group_id' => $id], 'group_id');

		$adminGroup = self::clearAllot($id);
		
		$adminGroup->saveAll($allude);

		if(!$adminGroup){
			throw new GroupException([
				'msg' => '群组成员分配失败'
			]);
		}

		return $adminGroup;
	}

	public static function clearAllot($id)
	{
		$adminGroup = new AdminGroupModel();

		if(!$adminGroup->where('group_id', $id)->delete(true)){
			throw new GroupException([
				'msg' => '群组成员删除失败'
			]);
		}

		return $adminGroup;
	}
}
