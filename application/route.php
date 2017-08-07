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

Route::get(':version/banner/:id',"api/:version.Banner/getBanner");

Route::get(':version/theme',"api/:version.Theme/getSimpleList");
Route::get(':version/theme/:id','api/:version.Theme/getComplexOne');

Route::group(':version/product',function(){
	Route::get('','api/:version.Product/getAll');
	Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
	Route::get('/recent','api/:version.Product/getRecent');
	Route::get('/by_category','api/:version.Product/getAllByCategory');
	Route::get('/search','api/:version.Product/getSearchByKeyWord');
	Route::get('/in_category/all','api/:version.Product/getAllInCategory');
	Route::post('','api/:version.Product/createProductBase');
	Route::put('/:id/stock_and_price','api/:version.Product/updateProductStockAndPrice');
	Route::put('/:id/pullOnOff','api/:version.Product/pullOnOffProduct');
	Route::put('/batch','api/:version.Product/batchUpdateProduct');
	Route::delete('/batch','api/:version.Product/batchRemoveProduct');
	Route::delete('/:id','api/:version.Product/removeProduct');
});

Route::group(':version/category',function(){
	Route::delete('/batch','api/:version.Category/batchRemoveCategory');
	Route::get('/all','api/:version.Category/getAllCategories');
	Route::put('/:id/product','api/:version.Category/updateProductList');
	Route::delete('/:id/product','api/:version.Category/removeProductList');
	Route::put('/:id','api/:version.Category/updateCategory');
	Route::delete('/:id','api/:version.Category/removeCategory');
	Route::post('','api/:version.Category/addCategory');
});

Route::group(':version/token',function (){
	Route::post('/user','api/:version.Token/getToken');
	Route::post('/verify','api/:version.Token/validateToken');
	Route::post('/admin','api/:version.Token/getAdminToken');
	Route::delete('/admin','api/:version.Token/logOnAdminToken');
});

Route::group(':version/address',function(){
	Route::post('','api/:version.Address/createOrUpdateAddress');
	Route::get('','api/:version.Address/getAddress');
});

Route::post(':version/order','api/:version.Order/placeOrder');
Route::get(':version/order/by_user','api/:version.Order/getSummaryByUser');
Route::get(':version/order/by_admin','api/:version.Order/getSummaryByAdmin');
Route::get(':version/order/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);

Route::post(':version/pay/pre_order','api/:version.Pay/getPreOrder');
Route::post(':version/pay/wxnotify','api/:version.Pay/receiveWxNotify');

Route::get(':version/search/all','api/:version.SearchWord/allSearch');

Route::post(':version/user/wx_info','api/:version.User/updateWxInfo');

Route::group(':version/admin',function (){
	Route::post('','api/:version.Admin/createAdmin');
});

Route::group(':version/image', function (){
	Route::post('/category_topic_img','api/:version.Image/uploadCategoryTopicImage');
	Route::post('/product_main_img','api/:version.Image/uploadProductMainImage');
});