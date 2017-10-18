<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::group('api', function(){
	Route::get('/:version/banner/:id',"api/:version.Banner/getBanner");

	Route::group('/:version/theme',function(){
		Route::get('',"api/:version.Theme/getSimpleList");
		Route::get('/all','api/:version.Theme/getAllThemes');
		Route::get('/:id','api/:version.Theme/getComplexOne',[],['id'=>'\d+']);
		Route::get('/:id/product','api/:version.Theme/getAllProduct',[],['id'=>'\d+']);
		Route::post('','api/:version.Theme/createTheme');
		Route::put('/:id/product','api/:version.Theme/updateProductList',[],['id'=>'\d+']);
		Route::put('/:id','api/:version.Theme/updateTheme');
		Route::delete('/:id','api/:version.Theme/removeTheme',[],['id'=>'\d+']);
		Route::delete('/batch','api/:version.Theme/batchRemoveTheme');
	});

	Route::group('/:version/product',function(){
		Route::get('','api/:version.Product/getAll');
		Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
		Route::get('/recent','api/:version.Product/getRecent');
		Route::get('/by_category','api/:version.Product/getAllByCategory');
		Route::get('/search','api/:version.Product/getSearchByKeyWord');
		Route::get('/all','api/:version.Product/getAllList');
		Route::get('/sales','api/:version.Product/getAllMonthSales');
		Route::get('/:id/sales','api/:version.Product/getOneMonthSales');
		Route::get('/:id/buynow', 'api/:version.Product/getAllBuyNow');
		Route::post('','api/:version.Product/createProductBase');
		Route::post('/:id/buynow', 'api/:version.Product/createBuyNow');
		Route::put('/:id','api/:version.Product/updateProductBase',[],['id'=>'\d+']);
		Route::put('/:id/stock_and_price','api/:version.Product/updateProductStockAndPrice');
		Route::put('/:id/detail','api/:version.Product/updateDetail');
		Route::put('/:id/properties','api/:version.Product/updateProperties');
		Route::put('/:id/pullOnOff','api/:version.Product/pullOnOffProduct');
		Route::put('/batch','api/:version.Product/batchUpdateProduct');
		Route::delete('/batch','api/:version.Product/batchRemoveProduct');
		Route::delete('/:id','api/:version.Product/removeProduct',[],['id'=>'\d+']);
		Route::delete('/:id/buynow/:bid', 'api/:version.Product/removeBuyNow', [], ['id'=>'\d+', 'bid'=>'\d+']);
	});

	Route::group('/:version/category',function(){
		Route::delete('/batch','api/:version.Category/batchRemoveCategory');
		Route::get('/all','api/:version.Category/getAllCategories');
		Route::put('/:id/product','api/:version.Category/updateProductList');
		Route::delete('/:id/product','api/:version.Category/removeProductList');
		Route::put('/:id','api/:version.Category/updateCategory',[],['id'=>'\d+']);
		Route::delete('/:id','api/:version.Category/removeCategory',[],['id'=>'\d+']);
		Route::post('','api/:version.Category/addCategory');
	});

	Route::group('/:version/token',function (){
		Route::post('/user','api/:version.Token/getToken');
		Route::post('/verify','api/:version.Token/validateToken');
		Route::post('/admin/relogin','api/:version.Token/reAdminToken');
		Route::post('/admin','api/:version.Token/getAdminToken');
		Route::delete('/admin','api/:version.Token/logOnAdminToken');
	});

	Route::group('/:version/address',function(){
		Route::post('','api/:version.Address/createOrUpdateAddress');
		Route::get('','api/:version.Address/getAddress');
	});

	Route::group('/:version/order', function (){
		Route::post('','api/:version.Order/placeOrder');
		Route::get('/by_user','api/:version.Order/getSummaryByUser');
		Route::get('/by_admin','api/:version.Order/getSummaryByAdmin');
		Route::get('/ticket/:bid','api/:version.Order/getTicketByBatchID',[],['bid'=>'\d+']);
		Route::get('/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);
		Route::get('buynow/:bid', 'api/:version.Order/getBuyNowByUser');
		Route::put('/by_admin/closed', 'api/:version.Order/closeOrders');
		Route::put('/by_admin/price/:id','api/:version.Order/updatePrice',[],['id'=>'\d+']);
		Route::put('/by_admin/delivery/:id','api/:version.Order/delivery',[],['id'=>'\d+']);
		Route::put('/by_admin/issue/:id','api/:version.Order/issue',[],['id'=>'\d+']);
		Route::delete('/by_admin/batch','api/:version.Order/batchRemoveOrder');
		Route::delete('/by_admin/:id','api/:version.Order/removeOrder',[],['id'=>'\d+']);
	});

	Route::post('/:version/pay/pre_order','api/:version.Pay/getPreOrder');
	Route::post('/:version/pay/wxnotify','api/:version.Pay/receiveWxNotify');

	Route::get('/:version/search/all','api/:version.SearchWord/allSearch');

	Route::group('/:version/user', function (){
		Route::get('','api/:version.User/getAll');
		Route::post('/wx_info','api/:version.User/updateWxInfo');
	});

	Route::group('/:version/admin',function (){
		Route::get('','api/:version.Admin/getAll');
		Route::post('','api/:version.Admin/createAdmin');
		Route::put('/:id','api/:version.Admin/updateAdmin');
		Route::put('/:id/status','api/:version.Admin/disOrEnable');
		Route::put('/batch','api/:version.Admin/batchUpdate');
		Route::delete('/:id','api/:version.Admin/removeAdmin');
		Route::delete('/batch','api/:version.Admin/batchRemoveAdmin');
	});

	Route::group('/:version/image', function (){
		Route::post('/theme_topic_img','api/:version.Image/uploadThemeTopicImage');
		Route::post('/theme_head_img','api/:version.Image/uploadThemeHeadImage');
		Route::post('/category_topic_img','api/:version.Image/uploadCategoryTopicImage');
		Route::post('/product_main_img','api/:version.Image/uploadProductMainImage');
		Route::post('/product_detail_img','api/:version.Image/uploadProductDetailImage');
		Route::post('/buy_now_rules_img','api/:version.Image/uploadBuyNowRulesImage');
	});

	Route::get('/:version/express_setting','api/:version.Express/getSetting');

	Route::group('/:version/express', function (){
		Route::get('/all', 'api/:version.Express/getAll');
		Route::post('', 'api/:version.Express/addExpress');
		Route::put('/:id', 'api/:version.Express/updateExpress', [], ['id' => '\d+']);
		Route::delete('/:id', 'api/:version.Express/removeExpress', [], ['id' => '\d+']);
		Route::delete('/batch', 'api/:version.Express/batchRemoveExpress');
	});

	Route::group('/:version/buynow', function (){
		Route::get('/:id', 'api/:version.Product/getOneBuyNow', [], ['id' => '\d+']);
		Route::get('/:id/stock', 'api/:version.Product/getBuyNowStock', [], ['id' => '\d+']);
	});
});
