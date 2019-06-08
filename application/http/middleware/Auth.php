<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:39
 */

namespace app\http\middleware;


use app\common\exception\NotLoginInException;

class Auth
{
    public function handle($request, \Closure $next, string $guard)
    {
        if (!config('auth.guard')[$guard]::checkLogin()) {
            if ($request->isAjax()) {
                throw new NotLoginInException();
            } else {
                return redirect('/' . $guard . '/login');
            }
        }
        return $next($request);
    }
}