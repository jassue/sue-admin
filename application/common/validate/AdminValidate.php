<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:51
 */

namespace app\common\validate;


use app\common\enum\BaseStatus;

class AdminValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|alpha|min:4|unique:admin',
        'password' => 'require|min:6|max:16',
        're_password' => 'require|confirm:password',
        'mobile' => 'require|mobile',
    ];

    protected $message = [
        'username.require' => '请输入用户名',
        'username.alpha' => '用户名必须为字母',
        'username.min' => '用户名不少于4位',
        'username.unique' => '用户名已存在',
        'username.exists' => '用户名不存在',
        'password.require' => '请输入密码',
        'password.min' => '密码不小于6位',
        'password.max' => '密码最多为16位',
        're_password.require' => '请输入确认密码',
        're_password.confirm' => '确认密码与密码不一致',
        'mobile.require' => '请输入手机号码',
        'mobile.mobile' => '手机号码格式错误'
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password'])
            ->remove('username', 'unique')
            ->append('username', 'exists:admin,username,' . BaseStatus::ENABLE . ',status');
    }

}