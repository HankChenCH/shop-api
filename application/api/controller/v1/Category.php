<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\validate\IDConllection;
use app\api\validate\ProductIDConllection;
use app\api\validate\CategoryInfo;
use app\api\service\Category as CategoryService;
use app\api\service\ProductManager;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category extends BaseController
{
	protected $beforeActionList = [
		'checkAdminScope' => ['only' => 'addCategory,updateCategory,removeCategory,batchRemoveCategory,updateProductList,removeProductList'],
	];

	public function getAllCategories()
	{
		$categories = CategoryModel::all([],'img');

		if ($categories->isEmpty()) {
			throw new CategoryException();
		}

		return $categories;
	}

	public function addCategory()
	{
		$validate = new CategoryInfo;
		$validate->scene('create');
		$validate->gocheck();

		$data = $validate->getDataOnScene(input('post.'));

		$categories = new CategoryModel;

		if (!$categories->save($data)) {
			throw new CategoryException([
				'errorCode' => 500001,
				'msg' => '创建分类失败',
				'code' => 417
			]);
		} else {
			return $categories;
		}
	}

	public function updateCategory($id)
	{
		$idValidate = new IDMustBePostiveInt;
		$idValidate->gocheck();

		$categoryInfoValidate = new CategoryInfo;
		$categoryInfoValidate->scene('update');
		$categoryInfoValidate->gocheck();

		$data = $categoryInfoValidate->getDataOnScene(input('put.'));

		$categories = CategoryModel::find($id);

		if (!$categories) {
			throw new CategoryException();
		}

		if (!$categories->save($data)) {
			throw new CategoryException([
				'errorCode' => 500002,
				'msg' => '更新分类失败',
				'code' => 417
			]);
		}

		return $categories;
	}

	public function removeCategory($id)
	{
		$validate = new IDMustBePostiveInt;
		$validate->gocheck();

		$flag = CategoryService::destroy($id);
		if (!$flag) {
			throw new CategoryException([
				'errorCode' => 500003,
				'msg' => '删除分类失败',
				'code' => 417
			]);
		}
		
		return $id;
	}

	public function batchRemoveCategory($ids='')
	{
		(new IDConllection())->goCheck();

		$flag = CategoryService::batchDestroy($ids);
		if (!$flag) {
			throw new CategoryException([
				'errorCode' => 500003,
				'msg' => '批量删除分类失败',
				'code' => 417
			]);
		}

		return $ids;
	}

	public function updateProductList($id)
	{
		$idValidate = new IDMustBePostiveInt;
		$idValidate->gocheck();

		$productIdsValidate = new ProductIDConllection;
		$productIdsValidate->gocheck();

		$newProductIds = input('put.product_id');

		$flag = ProductManager::managerByCategory($id, $newProductIds);
		if(!$flag){
			throw new CategoryException([
				'msg' => '商品更新分类失败',
				'errorCode' => 500010,
				'code' => 417
			]);
		}

		return $flag;
	}

	public function removeProductList($id)
	{
		$idValidate = new IDMustBePostiveInt;
		$idValidate->gocheck();

		$flag = ProductManager::managerByCategory($id);
		if(!$flag){
			throw new CategoryException([
				'msg' => '商品更新分类失败',
				'errorCode' => 500010,
				'code' => 417
			]);
		}

		return $flag;
	}
}