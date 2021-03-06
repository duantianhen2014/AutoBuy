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

// 主界面[FRONT_END]
Route::get('/', 'Frontend\\IndexController@index');
Route::post('/order/submit', 'Frontend\\OrderController@create')->name('order.post');

// 订单查询[FRONT_END]
Route::get('order/query', 'Frontend\\OrderController@queryPage')->name('order.query');
Route::post('order/query', 'Frontend\\OrderController@query')->middleware(['captcha.check']);

// 支付回调
Route::post('payment/notify', 'Frontend\\PaymentController@notify')->name('payment.notify');

// 用户路由
Auth::routes();
Route::get('/register', 'Backend\EmptyController@index');
Route::post('/register', 'Backend\EmptyController@index');

// 后台路由
Route::get('/home', 'Backend\HomeController@index')->name('admin')->middleware(['auth']);
Route::get('/admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth']);
Route::group([
    '/admin',
    'namespace' => 'Backend',
    'middleware' => ['auth'],
], function () {

    // 产品路由
    Route::get('/product/index', 'ProductController@index')->name('admin.product.index');
    Route::get('/product/add', 'ProductController@create')->name('admin.product.add');
    Route::post('/product/add', 'ProductController@store');
    Route::get('/product/{id}/edit', 'ProductController@edit')->name('admin.product.edit');
    Route::post('/product/{id}/edit', 'ProductController@update');
    Route::get('/product/{id}/destroy', 'ProductController@destroy')->name('admin.product.destroy');

    // 产品条例
    Route::get('/product/item/index', 'ProductItemController@index')->name('admin.product.item.index');
    Route::get('/product/item/add', 'ProductItemController@create')->name('admin.product.item.add');
    Route::post('/product/item/add', 'ProductItemController@store');
    Route::get('/product/item/{id}/destroy', 'ProductItemController@destroy')->name('admin.product.item.destroy');

    // 统计
    Route::get('/service/charts', 'ServiceController@index')->name('admin.service.charts');

    // 订单路由
    Route::get('/order/index', 'OrderController@index')->name('admin.order.index');
    Route::get('/order/{id}/destroy', 'OrderController@destroy')->name('admin.order.destroy');

    // 修改密码
    Route::get('/user/password', 'UserController@editPassword')->name('admin.user.password');
    Route::post('/user/password', 'UserController@updatePassword');
});