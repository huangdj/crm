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

Route::namespace('Api')->group(function () {
    Route::get('day_income', 'ApiController@day_income'); //管理员后台---教练每日课时费统计
    Route::get('month_income', 'ApiController@month_income'); //管理员后台---教练每月课时费统计
    Route::get('year_income', 'ApiController@year_income'); //管理员后台---教练全年课时费统计
    Route::get('get_courses', 'ApiController@get_courses'); // 所有课程
    Route::get('get_tests', 'ApiController@get_tests'); // 所有考勤

    /***
     * 会员前台接口路由
     */
    Route::prefix('customer')->group(function () {
        Route::post('login', 'CustomerController@login'); // 会员登录
        Route::put('reset_password', 'CustomerController@reset_password'); // 重设密码
        Route::post('send', 'CustomerController@send'); // 发送短信

        Route::middleware('auth:customers')->group(function () {
            Route::get('/', 'HomeController@index'); //会员首页
            Route::post('begin', 'HomeController@begin'); //开始上课
            Route::get('record', 'HomeController@record'); //上课记录
        });
    });
});

//Note:
//1. 当接口写完，创建前端项目后，后端项目需做跨域处理，参考文档： https://github.com/fruitcake/laravel-cors， 注需修改配置文件。
//2. 前端项目安装 axios，参考文档： https://www.kancloud.cn/yunye/axios/234845，安装完成后，在 main.js 文件中引入，测试读取接口，查看数据。
//3. 前端项目写拦截器，判断用户是否登录，如果没有，就跳转到登录页面，只有登录后才能进到首页。
