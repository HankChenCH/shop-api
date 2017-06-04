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
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;

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

	public function getAllByCategory($id)
	{
		(new IDMustBePostiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryID($id);

        if ($products->isEmpty()) {
        	throw new ProductException();
        }

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
}