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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function (){
    // 后台首页
    Route::get('/', 'IndexController@index')->name('admin.index');

    // 卡包管理
    Route::get('/cards', 'CardsController@index')->name('admin.cards.index');

    // 卡包分类
    Route::get('/card/category', 'CardCategorysController@index')->name('admin.cards.category.index');
    // 卡包分类添加
    Route::post('/card/category/store', 'CardCategorysController@store')->name('admin.cards.category.store');
    // 卡包分类编辑
    Route::get('/card/category/edit', 'CardCategorysController@edit')->name('admin.cards.category.edit');
    // 卡包分类保存
    Route::put('/card/category/update', 'CardCategorysController@update')->name('admin.cards.category.update');
    // 卡包分类删除
    Route::delete('/card/category/destroy', 'CardCategorysController@destroy')->name('admin.cards.category.destroy');
});
