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

Route::group(':version/theme',function(){
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

Route::group(':version/product',function(){
	Route::get('','api/:version.Product/getAll');
	Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
	Route::get('/recent','api/:version.Product/getRecent');
	Route::get('/by_category','api/:version.Product/getAllByCategory');
	Route::get('/search','api/:version.Product/getSearchByKeyWord');
	Route::get('/all','api/:version.Product/getAllList');
	Route::post('','api/:version.Product/createProductBase');
	Route::put('/:id','api/:version.Product/updateProductBase',[],['id'=>'\d+']);
	Route::put('/:id/stock_and_price','api/:version.Product/updateProductStockAndPrice');
	Route::put('/:id/detail','api/:version.Product/updateDetail');
	Route::put('/:id/properties','api/:version.Product/updateProperties');
	Route::put('/:id/pullOnOff','api/:version.Product/pullOnOffProduct');
	Route::put('/batch','api/:version.Product/batchUpdateProduct');
	Route::delete('/batch','api/:version.Product/batchRemoveProduct');
	Route::delete('/:id','api/:version.Product/removeProduct',[],['id'=>'\d+']);
});

Route::group(':version/category',function(){
	Route::delete('/batch','api/:version.Category/batchRemoveCategory');
	Route::get('/all','api/:version.Category/getAllCategories');
	Route::put('/:id/product','api/:version.Category/updateProductList');
	Route::delete('/:id/product','api/:version.Category/removeProductList');
	Route::put('/:id','api/:version.Category/updateCategory',[],['id'=>'\d+']);
	Route::delete('/:id','api/:version.Category/removeCategory',[],['id'=>'\d+']);
	Route::post('','api/:version.Category/addCategory');
});

Route::group(':version/token',function (){
	Route::post('/user','api/:version.Token/getToken');
	Route::post('/verify','api/:version.Token/validateToken');
	Route::post('/admin/relogin','api/:version.Token/reAdminToken');
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
Route::put(':version/order/by_admin/price/:id','api/:version.Order/updatePrice',[],['id'=>'\d+']);
Route::delete(':version/order/by_admin/batch','api/:version.Order/batchRemoveOrder');
Route::delete(':version/order/by_admin/:id','api/:version.Order/removeOrder',[],['id'=>'\d+']);

Route::post(':version/pay/pre_order','api/:version.Pay/getPreOrder');
Route::post(':version/pay/wxnotify','api/:version.Pay/receiveWxNotify');

Route::get(':version/search/all','api/:version.SearchWord/allSearch');

Route::group(':version/user', function (){
	Route::get('','api/:version.User/getAll');
	Route::post('/wx_info','api/:version.User/updateWxInfo');
});

Route::group(':version/admin',function (){
	Route::get('','api/:version.Admin/getAll');
	Route::post('','api/:version.Admin/createAdmin');
});

Route::group(':version/image', function (){
	Route::post('/theme_topic_img','api/:version.Image/uploadThemeTopicImage');
	Route::post('/theme_head_img','api/:version.Image/uploadThemeHeadImage');
	Route::post('/category_topic_img','api/:version.Image/uploadCategoryTopicImage');
	Route::post('/product_main_img','api/:version.Image/uploadProductMainImage');
	Route::post('/product_detail_img','api/:version.Image/uploadProductDetailImage');
});

Route::get(':version/express_setting','api/:version.Express/getSetting');