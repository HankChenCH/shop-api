<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\PagingParameterAdmin;
use app\api\validate\ProductParameter;
use app\api\validate\Keyword;
use app\api\model\Product as ProductModel;
use app\api\model\SearchWord as SearchWordModel;
use app\lib\exception\ProductException;
use app\lib\exception\ParameterException;

class Product
{
	public function getRecent($count=15)
	{
		(new Count())->goCheck();

		$products = ProductModel::getMostRecent($count);

		if ($products->isEmpty()) {
			throw new ProductException();
		}

		$products->hidden(['summary']);

		return $products;
	}

	public function getAllInCategory()
	{
		$products = ProductModel::all();

		if ($products->isEmpty()) {
			throw new ProductException();
		}

		return $products;
	}

	public function getAll($title='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$products = ProductModel::getAllBySearch($title, $createTime)
						->paginate($pageSize,false,['page' => $page]);

		if ($products->isEmpty()) {
			throw new ProductException();
		}

		return $products;
	}

	public function getAllByCategory($id)
	{
		(new IDMustBePostiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryID($id);

		return $products;
	}

	public function getOne($id)
	{
        (new IDMustBePostiveInt())->goCheck();

        $product = ProductModel::getProductDetail($id);

        if (!$product) {
        	throw new ProductException();
        }

        return $product;
	}

	public function getSearchByKeyWord($keyword, $page, $size)
	{
		$validate = new Keyword();
		$validate->scene('createAndUpdate');
 		$validate->goCheck();

 		$data = $validate->getDataOnScene(input('get.'));

		$products = ProductModel::getProductsByKeyWord($keyword,$page,$size);

		if ($products->isEmpty()) {
			throw new ProductException([
				'msg' => '无检索商品，请稍后再试！'
			]);
		}
		//将搜索词记录次数存入数据库
		$searchs = SearchWordModel::where('keyword','=',$keyword)->find();
		if (empty($searchs)) {
			$searchs = new SearchWordModel();
			$searchs->save($data);
		} else {
			SearchWordModel::where('keyword','=',$keyword)->setInc('count');
		}

		return $products;
	}

	public function updateProductStockAndPrice($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$productValidate = new ProductParameter();
		$productValidate->scene('updateStockAndPrice');
		$productValidate->goCheck();

		$data = $productValidate->getDataOnScene(input('put.'));

		$product = ProductModel::find($id);

		if (!$product->save($data)) {
			throw new ProductException([
				'msg' => '更新商品价格和库存失败',
				'errorCode' => 20010
			]);
		}

		return $product;
	}

	public function pullOnOffProduct($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$productValidate = new ProductParameter();
		$productValidate->scene('pullOnOff');
		$productValidate->goCheck();

		$data = $productValidate->getDataOnScene(input('put.'));

		$product = ProductModel::find($id);

		if (!$product->save($data)) {
			throw new ProductException([
				'msg' => '商品' . $data['is_on'] ? '上架' : '下架' . '失败',
				'errorCode' => 20011
			]);
		}

		return $product;
	}

	public function removeProduct($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$product = ProductModel::destroy($id);

		if (!$product) {
			throw new ProductException([
				'msg' => '删除商品失败'
			]);
		}

		return $product;
	}
}