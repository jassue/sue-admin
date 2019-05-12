<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/22
 * Time: 20:29
 */

namespace app\http\middleware;


use app\admin\facade\AdminMenus;
use app\admin\facade\Admins;
use think\facade\View;

class SetMenu
{
    public function handle($request, \Closure $next)
    {
        View::share('menuList', AdminMenus::getListByAdmin(Admins::user()));
        return $next($request);
    }
}