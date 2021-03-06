<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/toLogin', 'LoginController@toLogin')->name('toLogin');

});
Route::get('/', function () {
    return view('admin.login.index');
});



// 后台

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    // 后台首页
    Route::get('/', 'IndexController@index')->name('admin.index');

    // 宅配卡管理
    Route::get('/cards', 'CardsController@index')->name('admin.cards.index');
    // 宅配卡添加
    Route::post('/cards/store', 'CardsController@store')->name('admin.cards.store');
    // 宅配卡修改
    Route::get('/cards/edit', 'CardsController@edit')->name('admin.cards.edit');
    // 宅配卡删除
    Route::delete('/cards/destroy', 'CardsController@destroy')->name('admin.cards.destroy');
    // 宅配卡保存
    Route::post('/cards/update', 'CardsController@update')->name('admin.cards.update');


    // 宅配卡分类
    Route::get('/card/category', 'CardCategorysController@index')->name('admin.cards.category.index');
    // 宅配卡分类添加
    Route::post('/card/category/store', 'CardCategorysController@store')->name('admin.cards.category.store');
    // 宅配卡分类编辑
    Route::get('/card/category/edit', 'CardCategorysController@edit')->name('admin.cards.category.edit');
    // 宅配卡分类保存
    Route::put('/card/category/update', 'CardCategorysController@update')->name('admin.cards.category.update');
    // 宅配卡分类删除
    Route::delete('/card/category/destroy', 'CardCategorysController@destroy')->name('admin.cards.category.destroy');


    // 宅配卡导入列表
    Route::get('/card/excel', 'CardExcelController@index')->name('admin.card.excel.index');
    // 导出
    Route::get('/card/excel/export', 'CardExcelController@export')->name('admin.card.excel.export');
    // 导入
    Route::post('/card/excel/import', 'CardExcelController@import')->name('admin.card.excel.import');

    // 用户信息表
    Route::get('/users', 'UsersController@index')->name('admin.users.index');
    // 用户添加
    Route::post('/users/store', 'UsersController@store')->name('admin.users.store');
    // 用户修改
    Route::get('/users/edit', 'UsersController@edit')->name('admin.users.edit');
    // 用户删除
    Route::delete('/users/destroy', 'UsersController@destroy')->name('admin.users.destroy');
    // 用户保存
    Route::put('/users/update', 'UsersController@update')->name('admin.users.update');

    // 管理员信息表
    Route::get('/admins', 'AdminsController@index')->name('admin.admins.index');
    // 管理员添加
    Route::post('/admins/store', 'AdminsController@store')->name('admin.admins.store');
    // 管理员修改
    Route::get('/admins/edit', 'AdminsController@edit')->name('admin.admins.edit');
    // 管理员删除
    Route::delete('/admins/destroy', 'AdminsController@destroy')->name('admin.admins.destroy');
    // 管理员保存
    Route::put('/admins/update', 'AdminsController@update')->name('admin.admins.update');

    // 幻灯片管理
    Route::get('/banners', 'BannersController@index')->name('admin.banners.index');
    // 幻灯片添加
    Route::post('/banners/store', 'BannersController@store')->name('admin.banners.store');
    // 幻灯片修改
    Route::get('/banners/edit', 'BannersController@edit')->name('admin.banners.edit');
    // 幻灯片删除
    Route::delete('/banners/destroy', 'BannersController@destroy')->name('admin.banners.destroy');
    // 幻灯片保存
    Route::post('/banners/update', 'BannersController@update')->name('admin.banners.update');

    // 用户-宅配卡管理
    Route::get('/user/cards', 'UserCardsController@index')->name('admin.user.cards.index');
    // 用户-宅配卡添加
    Route::post('/user/cards/store', 'UserCardsController@store')->name('admin.user.cards.store');
    // 用户-宅配卡修改
    Route::get('/user/cards/edit', 'UserCardsController@edit')->name('admin.user.cards.edit');
    // 用户-宅配卡删除
    Route::delete('/user/cards/destroy', 'UserCardsController@destroy')->name('admin.user.cards.destroy');
    // 用户-宅配卡保存
    Route::put('/user/cards/update', 'UserCardsController@update')->name('admin.user.cards.update');

    // 宅配卡使用管理
    Route::get('/card/use', 'CardUseController@index')->name('admin.card.use.index');

    // 订单管理
    Route::get('/order/index', 'OrderController@index')->name('admin.order.index');

    // 地址管理
    Route::get('/address/index', 'AddressController@index')->name('admin.address.index');
    // 地址添加
    Route::post('/address/store', 'AddressController@store')->name('admin.address.store');
    // 地址修改
    Route::post('/address/update', 'AddressController@update')->name('admin.address.update');
    // 状态修改
    Route::post('/address/status', 'AddressController@status')->name('admin.address.status');
    // 删除
    Route::post('/address/destroy', 'AddressController@destroy')->name('admin.address.destroy');

    // 城市管理
    Route::get('/city/index', 'CityController@index')->name('admin.city.index');
    // 城市添加
    Route::post('/city/store', 'CityController@store')->name('admin.city.store');
    // 城市修改
    Route::post('/city/update', 'CityController@update')->name('admin.city.update');
    // 城市状态修改
    Route::post('/city/status', 'CityController@status')->name('admin.city.status');
    // 城市删除
    Route::post('/city/destroy', 'CityController@destroy')->name('admin.city.destroy');

    // 区域管理
    Route::get('/area/index', 'AreaController@index')->name('admin.area.index');
    // 区域添加
    Route::post('/area/store', 'AreaController@store')->name('admin.area.store');
    // 区域修改
    Route::post('/area/update', 'AreaController@update')->name('admin.area.update');
    // 区域状态修改
    Route::post('/area/status', 'AreaController@status')->name('admin.area.status');
    // 区域删除
    Route::post('/area/destroy', 'AreaController@destroy')->name('admin.area.destroy');



});
