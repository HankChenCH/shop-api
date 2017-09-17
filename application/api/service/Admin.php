<?php

namespace app\api\service;

use app\api\model\Admin as AdminModel;
use app\api\model\AdminProfile as AdminProfileModel;
use app\lib\exception\AdminException;
use think\Db;

class Admin 
{
	public static function create($data)
	{
		Db::startTrans();

		try{
			$admin = new AdminModel($data);
	    	$admin->allowField(true)->save();
			
	    	$admin->profile()->save($data['profile']);

	    	if (!$admin || !$admin->profile) {
	    		throw new AdminException([
	    			'msg' => '创建管理员失败'
    			]);
	    	}

			Db::commit();
	    	return $admin;
		}catch (\Exception $e){
			Db::rollback();
			throw $e;
		}
	}

	public static function update($id, $data)
	{
		Db::startTrans();

		try{

			$adminProfile = AdminProfileModel::where('admin_id', $id)
								->update($data['profile']);

			$admin = AdminModel::get($id);

			$admin->allowField(true)->save($data);

			if (!$admin || !$admin->profile) {
				throw new AdminException([
	    			'msg' => '更新管理员失败'
    			]);
			}

			Db::commit();
			return $admin;
		}catch (\Exception $e){
			Db::rollback();
			throw $e;
		}
	}
}