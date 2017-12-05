<?php

namespace app\api\service;

use app\api\model\Resource as ResourceModel;

class Auth
{
	public static function checkAuth(&$params)
	{
		$request=  \think\Request::instance();

        	$routeInfo = $request->routeInfo();

        	$rule = array_splice($routeInfo['rule'], 2);
        
        	$permission = strtoupper($routeInfo['option']['method']) . ' /' . implode('/', $rule);

        	$resource = ResourceModel::where('description', $permission)->find();

	        if ($resource && in_array($resource->permission_type, ['2','3'])){
				
		}
	}
}
