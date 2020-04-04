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

/***
 * 后台路由
 */
Route::prefix('admin')->group(function () {
    Auth::routes();

    //上传图片
    Route::resource('photos', 'PhotoController')->only('store');

    Route::namespace('Admin')->middleware('auth')->name('admin.')->group(function () {
        Route::get('/', 'HomeController@index'); // 后台首页

        Route::get('profile', 'HomeController@profile')->name('profile'); // 账户设置
        Route::put('update_profile', 'HomeController@update_profile')->name('update_profile'); // 修改账户
        Route::get('birthday', 'HomeController@birthday')->name('birthday'); //当天生日会员

        /***
         * 数据统计
         */
        Route::get('today_detail', 'HomeController@today_detail')->name('today_detail');  // 教练后台--当日上课明细
        Route::get('month_detail', 'HomeController@month_detail')->name('month_detail');  // 教练后台--当日上课明细
        Route::get('year_detail', 'HomeController@year_detail')->name('year_detail');  // 教练后台--全年上课明细
        Route::get('sell_day_detail', 'HomeController@sell_day_detail')->name('sell_day_detail');  // 教练后台--当日卖课明细
        Route::get('sell_mon_detail', 'HomeController@sell_mon_detail')->name('sell_mon_detail');  // 教练后台--当日卖课明细
        Route::get('sell_yea_detail', 'HomeController@sell_yea_detail')->name('sell_yea_detail');  // 教练后台--全年卖课明细

        Route::get('all_today_detail', 'HomeController@all_today_detail')->name('all_today_detail');  // 管理员后台--当日全部收入明细
        Route::get('all_month_detail', 'HomeController@all_month_detail')->name('all_month_detail');  // 管理员后台--当月全部收入明细
        Route::get('all_year_detail', 'HomeController@all_year_detail')->name('all_year_detail');  // 管理员后台--全年全部收入明细

        Route::get('sell_today_detail', 'HomeController@sell_today_detail')->name('sell_today_detail'); // 管理员后台--今日卖课明细
        Route::get('sell_month_detail', 'HomeController@sell_month_detail')->name('sell_month_detail'); // 管理员后台--当月卖课明细
        Route::get('sell_year_detail', 'HomeController@sell_year_detail')->name('sell_year_detail'); // 管理员后台--全年卖课明细

        Route::prefix('courses')->group(function () {
            Route::delete('destroy_checked', 'CourseController@destroy_checked')->name('courses.destroy_checked'); // 多选删除
        });
        Route::resource('courses', 'CourseController'); // 课程管理

        Route::get('courses/{course_id}/hours/create', 'HourController@create'); // 新增课时
        Route::get('courses/{course_id}/hours/edit/{id}', 'HourController@edit'); // 编辑课时
        Route::resource('hours', 'HourController')->only('store', 'update', 'destroy');   // 课时管理

        Route::resource('adverts', 'AdvertController'); // 广告管理

        Route::prefix('users')->group(function () {
            Route::delete('destroy_checked', 'UserController@destroy_checked')->name('users.destroy_checked'); // 多选删除
            Route::patch('dismiss', 'UserController@dismiss')->name('users.dismiss'); // 解雇教练
            Route::patch('res_dismiss', 'UserController@res_dismiss')->name('users.res_dismiss'); // 恢复教练职位

            Route::delete('del_one', 'UserController@del_one')->name('users.del_one'); // 删除KPI
            Route::get('kpi/{id}', 'UserController@kpi')->name('users.kpi'); // KPI设置
            Route::put('kpi_update/{id}', 'UserController@kpi_update')->name('users.kpi_update'); // 保存KPI设置
        });
        Route::resource('users', 'UserController')->except('destroy');  // 管理员、教练管理

        Route::prefix('customers')->group(function () {
            Route::get('buy/{id}', 'CustomerController@buy')->name('customers.buy'); // 后台--会员管理--购课
            Route::put('buy_update/{id}', 'CustomerController@buy_update')->name('customers.buy_update'); // 后台--会员管理--购课

            Route::get('relation/{id}', 'CustomerController@relation')->name('customers.relation'); // 后台--会员管理--赠课
            Route::put('relation_update/{id}', 'CustomerController@relation_update')->name('customers.relation_update'); // 后台--会员管理--赠课

            Route::delete('del_one', 'CustomerController@del_one')->name('customers.del_one'); // 删除购买课程
            Route::delete('del_relation', 'CustomerController@del_relation')->name('customers.del_relation'); // 删除赠送课程
        });
        Route::resource('customers', 'CustomerController');  // 会员管理

        Route::prefix('checkout')->group(function () {
            Route::get('export', 'CheckoutController@export')->name('checkout.export'); //导出文件
        });
        Route::resource('checkout', 'CheckoutController')->only('index', 'create', 'store'); // 工资结算

        Route::get('data', 'DataController@index')->name('data.index');  // 加载数据备份页面
        Route::get('data/export', 'DataController@export')->name('data.export');  // 导出SQL文件

        Route::prefix('records')->group(function () {
            Route::patch('makeSure', 'RecordController@makeSure')->name('records.makeSure'); //确认上课
        });
        Route::resource('records', 'RecordController')->only('index');  // 教练后台--上课管理

        Route::prefix('attendances')->group(function () {
            Route::post('import', 'AttendanceController@import')->name('attendances.import'); // 导入考勤
        });
        Route::resource('attendances', 'AttendanceController')->only('index'); // 考勤管理
    });
});

