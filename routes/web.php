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
/**
 * 首页
 */
Route::get('/', function () {
    return redirect()->route('login');
});

/**
 * 登录验证
 */
Auth::routes();

/**
 * 管理首页
 */
Route::get('/home', 'HomeController@index')->name('home');

/**
 * 账户管理
 */
Route::group(['namespace' => 'Account','middleware' => 'auth'], function(){
    Route::get('/account', 'AccountController@index')->name('account');
    Route::match(['get', 'post'],'/account/add', 'AccountController@add');
    Route::get('/account/del/{id}', 'AccountController@del');
    Route::match(['get', 'post'],'/account/save/{id}', 'AccountController@save');
    Route::match(['get', 'post'],'/account/reply/{id}', 'AccountController@reply');
    Route::post('/account/upload_image', 'AccountController@upload_image');
});

/**
 * 关注后定时消息
 */
Route::group(['namespace' => 'CustomerService','middleware' => 'auth'], function(){
    Route::match(['get', 'post'],'/customerservice/{id}', 'CustomerServiceController@index');
});

/**
 * 群发
 */
Route::group(['namespace' => 'GroupSending','middleware' => 'auth'], function(){
    Route::match(['get', 'post'],'/groupsending/{id}', 'GroupSendingController@index');
    Route::get('/groupsending/list/{id}', 'GroupSendingController@get_list');
    Route::get('/groupsending/send/{id}', 'GroupSendingController@send');
    Route::get('/groupsending/details/{id}', 'GroupSendingController@details');
    Route::get('/groupsending/task_logs/{id}', 'GroupSendingController@task_log');
});

/**
 * 接口日志
 */
Route::group(['namespace' => 'InterfaceLog','middleware' => 'auth'], function(){
    Route::get('/interfaceLog', 'InterfaceLogController@index');
});

/**
 * Api
 */
Route::group(['namespace' => 'Api'], function(){
    Route::post('/uploadImg', 'UploadController@uploadImg')->name('uploadImg');
});


