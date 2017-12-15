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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    // 后台首页
    Route::get('/', 'IndexController@index')->name('admin.index');

    // 宅配卡管理
    Route::get('/cards', 'CardsController@index')->name('admin.cards.index');
    // 宅配卡添加
    Route::post('/cards/store', 'CardsController@store')->name('admin.cards.store');


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
});
