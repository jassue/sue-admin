<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 18:23
 */

namespace app\admin\controller;


class Index extends BaseController
{
    /**
     * @return \think\response\View
     */
    public function index()
    {
        return view('index');
    }
}