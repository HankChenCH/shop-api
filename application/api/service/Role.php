<?php

namespace app\api\service;

use app\api\model\Role as RoleModel;
use app\api\model\RoleResource as RoleResourceModel;
use app\lib\exception\RoleException;
use think\Db;
use think\Log;

class Role
{
	public static function create($data)
	{
		Db::startTrans();
		try {
			
			$role = new RoleModel();
			$role->allowField(true)->save($data);

			if (!$role) {
				throw new RoleException([
					'msg' => '创建角色失败'
				]);
			}

			$roleResourceAllude = RoleResourceModel::processAllude(['resource_id' => $data['role_resource'], 'role_id' => $role->id], 'role_id');

			$roleResource = new RoleResourceModel();

			$roleResource->saveAll($roleResourceAllude);

			if (!$roleResource) {
				throw new RoleException([
					'msg' => '创建角色授权失败'
				]);
			}

			Db::commit();
			return $role;

		} catch (\Exception $e) {
			Db::rollback();

			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');

			throw $e;
		}
	}

	public static function update($data, $id)
	{
		Db::startTrans();

		try{

			$role = RoleModel::get($id);
			$role->allowField(true)->save($data);

			if (!$role) {
				throw new RoleException([
					'msg' => '更新角色失败'
				]);
			}

			$roleResourceAllude = RoleResourceModel::processAllude(['resource_id' => $data['role_resource'], 'role_id' => $role->id], 'role_id');

			$roleResource = new RoleResourceModel();

			$roleResource->where('role_id', $role->id)->delete(true);

			$roleResource->saveAll($roleResourceAllude);

			if (!$roleResource) {
				throw new RoleException([
					'msg' => '更新角色授权失败'
				]);
			}

			Db::commit();
			return $role;

		} catch (\Exception $e) {
			Db::rollback();

			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');

			throw $e;
		}
	}

	public static function remove($id)
	{
		Db::startTrans();

		try {

			$role = RoleModel::destroy($id);

			if (!$role) {
				throw new RoleException([
					'msg' => '删除角色失败'
				]);
			}

			$roleResource = RoleResourceModel::where('role_id', $id)->delete(true);

			if (!$roleResource) {
				throw new RoleException([
					'msg' => '删除角色授权数据失败'
				]);
			}

			Db::commit();
			return $role;

		} catch (\Exception $e) {

			Db::rollback();

			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');

			throw $e;
			
		}
	}
}
