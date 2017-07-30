<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:31
 */

namespace app\api\service;

use think\Db;
use app\api\service\ProductManager;
use app\api\model\Product as ProductModel;
use app\api\model\Category as CategoryModel;

class Category
{
	public static function destroy($categoryId)
	{
		Db::startTrans();

		try{

			$affectNum = ProductManager::managerByCategory($categoryId);

			$affectCount = CategoryModel::destroy($categoryId);

			Db::commit();
			return true;
		}catch(\Exception $e){

			Db::rollback();
			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');
			return false;
		}
	}

	public static function batchDestroy($categoryIds)
	{
		Db::startTrans();

		try{

			$affectNum = ProductManager::clearByCategory($categoryIds);

			$affectCount = CategoryModel::destroy($categoryIds);

			Db::commit();
			return true;
		}catch(\Exception $e){

			Db::rollback();
			Log::init([
                'type'=>'File',
                'path'=>LOG_PATH,
                'level'=>['error']
            ]);
			Log::record($e,'error');
			return false;
		}
	}
}