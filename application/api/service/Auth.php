<?php

namespace app\api\service;

use app\api\model\Admin as AdminModel;
use app\api\model\Resource as ResourceModel;
use app\lib\enum\PermissionTypeEnum;
use app\lib\enum\ResourceTypeEnum;
use app\lib\exception\PermissionException;
use app\lib\exception\AdminException;

class Auth
{
	public static function checkAuth(&$params)
	{
		$resource = self::getCurrentResource();

		if ($resource && in_array($resource->permission_type, [PermissionTypeEnum::PROTECTED, PermissionTypeEnum::PRIVATE])) {
			
			$userPermission = self::getUserPermission();
	
			if(!in_array($resource->description, $userPermission)) {
				throw new PermissionException();
			}

		}
	}

	private static function getCurrentResource()
	{
		$request=  \think\Request::instance();

                $routeInfo = $request->routeInfo();

                $rule = array_splice($routeInfo['rule'], 2);

                $permission = strtoupper($routeInfo['option']['method']) . ' /' . implode('/', $rule);

                return ResourceModel::where('description', $permission)->find();
	}

	private static function getUserPermission()
	{
		$uid = Token::getCurrentUid();
                        $admin = AdminModel::with(['roles', 'roles.resources'])
                                        ->find($uid);

                        if (!$admin){
                                throw new AdminException();
                        }

                        $userResource = self::getUserResource($admin, [ResourceTypeEnum::DATA]);

			return $userResource[ResourceTypeEnum::DATA];
	}

	public static function getUserResource($admin,$type=[ResourceTypeEnum::VIEW,ResourceTypeEnum::DATA])
	{
		$userPermission = [];
                foreach($admin->roles as $role) {
                        foreach($role->resources as $resource) {
                                if (!in_array($resource->resource_type, $type))continue;
                                $userPermission[$resource->resource_type][] = $resource->description;
                        }
                }

                foreach ($type as $t) {
			array_unique($userPermission[$t]);
		}
                return $userPermission;
	}
}
