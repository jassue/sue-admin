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

Route::group('admin', function () {
    Route::get('/login', 'Admin/loginPage');
    Route::post('/login', 'Admin/login');
    Route::group('/', function () {
        Route::get('/', 'Index/index')->middleware('Check:ACCESS_CONTROL');
    })->middleware('Auth:admin');
})->prefix('admin/');
