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

// Route::get(':version/product/recent','api/:version.Product/getRecent');
// Route::get(':version/product/by_category','api/:version.Product/getAllByCategory');
// Route::get(':version/product/:id','api/:version.Product/getOne');

Route::group(':version/product',function(){
	Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
	Route::get('/recent','api/:version.Product/getRecent');
	Route::get('/by_category','api/:version.Product/getAllByCategory');
});

Route::get(':version/category/all','api/:version.Category/getAllCategories');

Route::post(':version/token/user','api/:version.Token/getToken');
Route::post(':version/token/verify','api/:version.Token/validateToken');
Route::post(':version/token/admin','api/:version.Token/getAdminToken');

Route::group(':version/address',function(){
	Route::post('','api/:version.Address/createOrUpdateAddress');
	Route::get('','api/:version.Address/getAddress');
});

Route::post(':version/order','api/:version.Order/placeOrder');
Route::get(':version/order/by_user','api/:version.Order/getSummaryByUser');
Route::get(':version/order/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);

Route::post(':version/pay/pre_order','api/:version.Pay/getPreOrder');
Route::post(':version/pay/wxnotify','api/:version.Pay/receiveWxNotify');
