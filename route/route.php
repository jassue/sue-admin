<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::group('admin', function () {
    Route::get('/login', 'Admin/loginPage');
    Route::post('/login', 'Admin/login');
    Route::group('/', function () {
        Route::get('/', 'Index/index');
        Route::group('/role', function () {
            Route::get('/', 'Role/index');
        });
        Route::group('/admin', function () {
            Route::get('/', 'Admin/index');
            Route::post('/', 'Admin/list');
            Route::get('/create', 'Admin/create');
            Route::post('/create', 'Admin/save');
            Route::get('/edit/:id', 'Admin/edit');
            Route::post('/update', 'Admin/update');
            Route::post('/delete', 'Admin/delete');
        });
        Route::group('/rule', function () {
            Route::get('/', 'Rule/index');
        });
        Route::group('/menu', function () {
            Route::get('/', 'Menu/index');
        });
    })->middleware(['Auth:admin', 'CheckRule', 'SetMenu']);
})->prefix('admin/');
