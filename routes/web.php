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

// qpi 接口 用于微信小程序
//Route::group(['namespace' => 'Api\V1', 'prefix' => 'wx'], function () {
//    Route::get('/banner', 'BannerController@getBanner');
//    // Token
//    Route::post('/token/user', 'TokenController@getToken');
//});

Route::get('/', function () {
    return view('welcome');
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

});
