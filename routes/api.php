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

    // 开通宅配卡
    Route::post('/activation', 'CardsController@activation');
    // 已开通账号
    Route::get('/user/cards', 'UserCardsController@getCardsHas');
    // 未开通账号
    Route::get('/user/open/cards', 'UserCardsController@getNoOpenCardsHas');
    // 开通账号
    Route::post('/user/open/cards/now', 'UserCardsController@openCardsHas');
    // 可使用账号
    Route::get('/user/cards/use', 'UserCardsController@canUseCards');
    Route::get('/user/cards/use/info', 'UserCardsController@canUseCardsInfoLists');
    // 可使用账号详情
    Route::get('/user/cards/info', 'UserCardsController@canUseCardsInfo');
    // 使用配送卡
    Route::post('/use/cards/user', 'UserCardsController@useCardByUser');


    // Token
    Route::post('/token/user', 'TokenController@getToken');
    Route::post('/token/verify', 'TokenController@verifyToken');

    // 修改地址
    Route::post('/address', 'UserAddressController@createOrUpdateAddress');
    Route::get('/address/info', 'UserAddressController@getUserAddress');

    // 支付接口
    Route::post('/order', 'OrderController@placeOrder');
    // 获取订单详细信息
    Route::get('/order', 'OrderController@getDetail');
    // 获取订单详细信息
    Route::get('/order/info', 'OrderController@getOrderInfo');

    // 全部订单
    Route::get('/order/order/list', 'OrderController@orderList');
    // 获取订单信息
    Route::get('/order/by_user', 'OrderController@getSummaryByUser');
    // 支付
    Route::post('/pay/pre_order', 'PayController@getPreOrder');
    // 微信会掉回调
    Route::post('/pay/notify', 'PayController@receiveNotify');

//    Route::post('/pay/re_notify', 'PayController@redirectNotify');

    Route::get('/address', 'AddressController@index');
    Route::get('/address/city', 'AddressController@city');
    Route::get('/address/areas', 'AddressController@area');
    Route::get('/address/city/name', 'AddressController@cityByName');
    Route::get('/address/area/name', 'AddressController@areaByName');
    Route::get('/user/address/info', 'AddressController@getUserInfo');

    // 保存地址信息
    Route::post('/user/save/name', 'UserAddressController@saveAddress');

    // 获取手机号验证码
    Route::get('/phone/code', 'UserAddressController@getPhoneCode');
    Route::post('/phone/update', 'UserAddressController@phoneUpdate');



});
