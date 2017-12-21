<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// qpi 接口 用于微信小程序
Route::group(['namespace' => 'Api\V1'], function () {
    // 获取轮播图
    Route::get('/banner', 'BannerController@getBanner');


    // 获取宅配卡列表
    Route::get('/cards', 'CardsController@getCards');
    // 获取宅配卡信息
    Route::get('/card/{id}', 'CardsController@getOneCardById');

    // Token
    Route::post('/token/user', 'TokenController@getToken');
    // 修改地址
    Route::post('/user/address', 'UserAddressController@createOrUpdateAddress');

    // 支付接口
    Route::post('/order', 'OrderController@placeOrder');
    // 获取订单详细信息
    Route::get('/order', 'OrderController@getDetail');
    // 获取订单信息
    Route::get('/order/by_user', 'OrderController@getSummaryByUser');
    // 支付
    Route::post('/pay/pre_order', 'PayController@getPreOrder');
    // 微信会掉回调
    Route::post('/pay/notify', 'PayController@receiveNotify');
    Route::post('/pay/re_notify', 'PayController@redirectNotify');

});
