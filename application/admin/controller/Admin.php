<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:49
 */

namespace app\admin\controller;


use app\admin\facade\Admins;
use app\common\exception\InvalidPasswordException;
use app\common\response\SuccessResult;
use app\common\facade\Auth;
use app\common\validate\AdminValidate;
use think\Request;

class Admin extends BaseController
{
    /**
     * @return \think\response\View
     */
    public function loginPage()
    {
        return view('/login');
    }

    /**
     * @param Request $request
     * @return SuccessResult
     * @throws InvalidPasswordException
     */
    public function login(Request $request)
    {
        (new AdminValidate())->goCheck('login', false);
        $admin = Admins::getByUsername($request->post('username'));
        $result = Admins::checkPassword($admin, $request->post('password'));
        if (!$result)
            throw new InvalidPasswordException();
        Auth::guard('admin')->login($admin);
        return new SuccessResult();
    }
}