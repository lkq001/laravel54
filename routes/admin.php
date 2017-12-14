<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/11/27
 * Time: 09:25
 * author 李克勤
 */
Route::group(['middleware' => 'Admin'], function () {
    Route::get('/posts', 'PostsController@index');
});
