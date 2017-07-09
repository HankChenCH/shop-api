<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/4/21
 * Time: 11:45
 */

namespace app\api\controller\v1;

use app\api\validate\PagingParameter;
use app\api\model\SearchWord as SearchWordModel;
use app\lib\exception\SearchwordException;

class SearchWord extends BaseController
{
	protected $beforeActionList = [];

	public function allSearch($page=1, $size=5)
	{
		(new PagingParameter)->gocheck();

		$searchData = SearchWordModel::where('delete_time','IS NULL')
					->order('count desc')
					->paginate($size,true,['page' => $page]);

		if ($searchData->isEmpty()) {
			throw new SearchwordException();
		}

		return $searchData;
	}
}