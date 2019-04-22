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

Route::get('/', 'Index/index');

Route::group('admin', function () {
    Route::get('/login', 'Admin/loginPage');
    Route::post('/login', 'Admin/login');
    Route::group('/', function () {
        Route::get('/index', 'Index/index');
        Route::group('/role', function () {
            Route::get('/', 'Role/index');
        })->middleware('Check:ROLE_LIST');
        Route::group('/admin', function () {
            Route::get('/', 'Admin/index');
        })->middleware('Check:ADMIN_LIST');
        Route::group('/rule', function () {
            Route::get('/', 'Rule/index');
        })->middleware('Check:RULE_LIST');
        Route::group('/menu', function () {
            Route::get('/', 'Menu/index');
        })->middleware('Check:ADMIN_MENU_LIST');
    })->middleware(['Auth:admin', 'SetMenu']);
})->prefix('admin/');
