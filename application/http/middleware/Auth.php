<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:39
 */

namespace app\http\middleware;


use app\admin\facade\Admins;
use app\common\exception\NotLoginInException;

class Auth
{
    public function handle($request, \Closure $next, string $guard)
    {
        if (!Admins::checkLogin()) {
            if ($request->isAjax()) {
                throw new NotLoginInException();
            } else {
                return redirect('/' . $guard . '/login');
            }
        }
        return $next($request);
    }
}