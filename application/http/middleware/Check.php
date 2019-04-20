<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 22:00
 */

namespace app\http\middleware;


use app\admin\exception\NoAuthForAccessException;
use app\admin\facade\AdminRules;
use app\common\facade\Auth;

class Check
{
    public function handle($request, \Closure $next, string $auth)
    {
        if (!AdminRules::checkRuleByAdmin(Auth::guard('admin')->user(), $auth)) {
            if ($request->isAjax()) {
                throw new NoAuthForAccessException();
            } else {
                exception('您无权访问该功能');
            }
        }
        return $next($request);
    }
}