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
    Route::get('/logout', 'Admin/logout')->middleware('Auth:admin');
    Route::get('/profile', 'Admin/profile')->middleware(['Auth:admin', 'SetMenu']);
    Route::post('/profile', 'Admin/setProfile')->middleware(['Auth:admin', 'SetMenu']);
    Route::post('/uploadImage', 'Common/uploadImage')->middleware('Auth:admin');
    Route::group('/', function () {
        Route::get('/', 'Index/index');
        Route::group('/role', function () {
            Route::get('/', 'AdminRole/index');
            Route::post('/', 'AdminRole/list');
            Route::get('/create', 'AdminRole/create');
            Route::post('/create', 'AdminRole/save');
            Route::get('/edit', 'AdminRole/edit');
            Route::post('/edit', 'AdminRole/update');
            Route::post('/delete', 'AdminRole/delete');
        });
        Route::group('/admin', function () {
            Route::get('/', 'Admin/index');
            Route::post('/', 'Admin/list');
            Route::get('/create', 'Admin/create');
            Route::post('/create', 'Admin/save');
            Route::post('/toggle', 'Admin/toggleStatus');
            Route::get('/edit', 'Admin/edit');
            Route::post('/edit', 'Admin/update');
            Route::post('/delete', 'Admin/delete');
        });
        Route::group('/rule', function () {
            Route::get('/', 'AdminRule/index');
            Route::get('/create', 'AdminRule/create');
            Route::post('/create', 'AdminRule/save');
            Route::get('/edit', 'AdminRule/edit');
            Route::post('/edit', 'AdminRule/update');
            Route::post('/delete', 'AdminRule/delete');
        });
        Route::group('/menu', function () {
            Route::get('/', 'AdminMenu/index');
            Route::get('/create', 'AdminMenu/create');
            Route::post('/create', 'AdminMenu/save');
            Route::get('/edit', 'AdminMenu/edit');
            Route::post('/edit', 'AdminMenu/update');
            Route::post('/delete', 'AdminMenu/delete');
        });
    })->middleware(['Auth:admin', 'CheckRule', 'SetMenu']);
})->prefix('admin/');
