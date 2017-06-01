<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;

use app\lib\exception\CategoryException;
use app\api\model\Category as CategoryModel;

class Category
{
	public function getAllCategories()
	{
		$categories = CategoryModel::all([],'img');

		if ($categories->isEmpty()) {
			throw new CategoryException();
		}

		return $categories;
	}
}