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
use app\api\validate\IDConllection;
use app\api\validate\CountMonthInt;
use app\api\validate\PagingParameterAdmin;
use app\api\validate\ProductParameter;
use app\api\validate\Keyword;
use app\api\validate\BuyNow;
use app\api\service\Product as ProductService;
use app\api\model\Product as ProductModel;
use app\api\model\ProductBuynow as BuyNowModel;
use app\api\model\SearchWord as SearchWordModel;
use app\api\model\BuyNowRedis;
use app\lib\enum\SaveFileFromEnum;
use app\lib\exception\ProductException;
use app\lib\exception\ParameterException;
use app\lib\exception\BuyNowException;

class Product extends BaseController
{
	protected $beforeActionList = [
		'checkAdminScope' => ['only' => 'getAllList,getAll,getMonthSales,createProductBase,updateStockAndPrice,updateProductBase,,updateDetail,removeProduct,batchUpdateProduct,batchRemoveProduct,updateProperties,pullOnOffProduct'],
	];

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

	public function getAllList()
	{
		$products = (new ProductModel)->order('create_time desc')
						->select();

		if ($products->isEmpty()) {
			throw new ProductException();
		}

		return $products;
	}

	public function getAll($title='', $createTime=array(), $page=1, $pageSize=10)
	{
		(new PagingParameterAdmin())->goCheck();

		$products = ProductModel::getAllBySearch(['name' => $title, 'create_time' => $createTime])
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

	public function getAllMonthSales($countMonth)
	{
		(new CountMonthInt())->goCheck();

		$productCount = ProductService::countSales($countMonth);

		return $productCount;
	}

	public function getOneMonthSales($id, $countMonth)
	{
		(new IDMustBePostiveInt())->goCheck();
		(new CountMonthInt())->goCheck();

		$productCount = ProductService::countSales($countMonth, $id);

		return $productCount;
	}

	public function getOne($id)
	{
        	(new IDMustBePostiveInt())->goCheck();

        	$product = ProductService::getProductAllDetail($id);

        	return $product;
	}

	public function getAllBuyNow($id)
	{
		(new IDMustBePostiveInt)->goCheck();

		$buyNows = BuyNowModel::where('product_id', $id)
						->order('create_time desc')
						->select();

		if ($buyNows->isEmpty()) {
			throw new BuyNowException([
				'msg' => '秒杀不存在'
			]);
		}

		return $buyNows;
	}

	public function getOneBuyNow($id)
	{
		(new IDMustBePostiveInt)->goCheck();
		
		$buyNowRedis = new BuyNowRedis($id);
		$buyNow = $buyNowRedis->getData($id);
		
		if (!$buyNow) {
			$buyNow = BuyNowModal::get($id);
		}

		if (!$buyNow) {
			throw new BuyNowException([
				'msg' => '秒杀不存在'
			]);
		}

		return array_merge($buyNow->toArray(), ['serverNow' => time()]);
	}

	public function getBuyNowStock($id)
	{
		$buyNowRedis = new BuyNowRedis($id);
		$nowStock = $buyNowRedis->getStock($id);

		if (!$nowStock || $nowStock < 0) {
			return 0;
		}

		return $nowStock;
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

	public function createProductBase()
	{
		$validate = new ProductParameter();
		$validate->scene('baseCreate');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));
		
		if ($data['from'] === SaveFileFromEnum::LOCAL) {
			$data['main_img_url'] = str_replace(config('setting.img_prefix'), '', $data['main_img_url']);
		} elseif ($data['from'] === SaveFileFromEnum::QINIU) {
			$data['main_img_url'] = str_replace(config('setting.qiniu_prefix'), '', $data['main_img_url']);
		}

		$product = ProductModel::create($data);

		if (!$product) {
			throw new ProductException([
				'msg' => '创建商品失败'
			]);
		}

		return $product;
	}

	public function createBuyNow($id)
	{
		(new IDMustBePostiveInt)->goCheck();

		$validate = new BuyNow();
		$validate->scene('create');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('post.'));

		$buyNow = ProductService::createBuyNow($id, $data);

		return $buyNow;
	}

	public function updateProductBase($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$validate = new ProductParameter();
		$validate->scene('baseUpdate');
		$validate->goCheck();

		$data = $validate->getDataOnScene(input('put.'));
		$imgData = input('put.');
		
		if (isset($imgData['from'])) {
			if ($imgData['from'] === SaveFileFromEnum::LOCAL) {
				$imgData['main_img_url'] = str_replace(config('setting.img_prefix'), '', $imgData['main_img_url']);
			} elseif ($imgData['from'] === SaveFileFromEnum::QINIU) {
				$imgData['main_img_url'] = str_replace(config('setting.qiniu_prefix'), '', $imgData['main_img_url']);
			}
			
			$data['from'] = $imgData['from'];
			$data['main_img_url'] = $imgData['main_img_url'];
			$data['img_id'] = $imgData['img_id'];
		}

		$product = new ProductModel();
		$product->save($data, ['id' => $id]);

		if (!$product) {
			throw new ProductException([
				'msg' => '更新商品基础信息失败'
			]);
		}

		return $product;
	}

	public function updateDetail($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$data = input('put.');

		$productDetail = ProductService::createOrUpdateDetail($id, $data);

		if (!$productDetail) {
			throw new ProductException([
				'msg' => '更新商品详情失败'	
			]);
		}

		return $productDetail;
	}

	public function updateProperties($id)
	{
		(new IDMustBePostiveInt())->goCheck();

		$data = input('put.properties/a');

		$productProps = ProductService::createOrUpdateProperties($id, $data);

		if (!$productProps) {
			throw new ProductException([
				'msg' => '更新商品规格参数失败'	
			]);
		}

		return $productProps;
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

	public function removeBuyNow($id, $bid)
	{
		(new IDMustBePostiveInt)->goCheck();

		$buyNow = BuyNowModel::destroy($bid);

		if (!$buyNow) {
			throw new BuyNowException([
				'msg' => '删除秒杀失败'
			]);
		}

		return $buyNow;
	}

	public function batchUpdateProduct()
	{
		(new IDConllection())->goCheck();

		$productValidate = new ProductParameter();
		$productValidate->scene('pullOnOff');
		$productValidate->goCheck();

		$data = $productValidate->getDataOnScene(input('put.'));

		$products = ProductModel::batchUpdate(input('put.ids'), $data);
		// $products->save($data,function($query){
		//     $query->where('id','in',input('put.ids'));
		// });

		if (!$products) {
			throw new ProductException([
				'msg' => '批量更新失败'
			]);
		}

		return $products;
	}

	public function batchRemoveProduct()
	{
		(new IDConllection())->goCheck();

		$ids = input('delete.ids');
		$products = ProductModel::destroy($ids);

		if (!$products) {
			throw new ProductException([
				'msg' => '批量删除商品失败'
			]);
		}

		return $products;
	}
}
