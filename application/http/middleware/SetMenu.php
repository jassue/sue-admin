<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/22
 * Time: 20:29
 */

namespace app\http\middleware;


use app\admin\facade\AdminMenus;
use app\common\facade\Auth as UserAuthService;
use think\facade\View;

class SetMenu
{
    public function handle($request, \Closure $next)
    {
        View::share('menuList', AdminMenus::getListByAdmin(UserAuthService::guard('admin')->user()));
        return $next($request);
    }
}