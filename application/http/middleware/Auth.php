<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:39
 */

namespace app\http\middleware;


use app\common\facade\Auth as UserAuthService;
use app\common\exception\NotLoginInException;

class Auth
{
    public function handle($request, \Closure $next, string $guard)
    {
        if (!UserAuthService::guard($guard)->check()) {
            if ($request->isAjax()) {
                throw new NotLoginInException();
            } else {
                return redirect('/' . $guard . '/login');
            }
        }
        return $next($request);
    }
}