<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:51
 */

namespace app\common\validate;


use app\common\enum\BaseStatus;
use think\facade\Request;

class AdminValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|alpha|min:4|unique:admin',
        'name' => 'require|min:2|max:16',
        'password' => 'require|min:6|max:16',
        're_password' => 'require|confirm:password',
        'mobile' => 'require|mobile|unique:admin,mobile_phone',
        'roles' => 'require|array'
    ];

    protected $message = [
        'id.require' => 'id不能为空',
        'id.integer' => 'id必须为整数',
        'id.egt'     => 'id数据错误',
        'id.exists' => 'id不存在',
        'username.require' => '请输入用户名',
        'username.alpha' => '用户名必须为字母',
        'username.min' => '用户名不少于4位',
        'username.unique' => '用户名已存在',
        'username.exists' => '用户名不存在',
        'name.require' => '请输入昵称',
        'name.min' => '昵称不少于4位',
        'name.max' => '昵称最多为16位',
        'password.require' => '请输入密码',
        'password.min' => '密码不小于6位',
        'password.max' => '密码最多为16位',
        're_password.require' => '请输入确认密码',
        're_password.requireWith' => '请输入确认密码',
        're_password.confirm' => '确认密码与密码不一致',
        'mobile.require' => '请输入手机号码',
        'mobile.mobile' => '手机号码格式错误',
        'mobile.unique' => '手机号码已存在',
        'roles.require' => '请选择角色',
        'roles.array' => '角色格式错误',
        'status.require' => '请选择状态',
        'status.in' => '状态选择错误'
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password'])
            ->remove('username', ['alpha', 'min', 'unique'])
            ->append('username', 'exists:admin,username,' . BaseStatus::ENABLE . ',status');
    }

    public function sceneToggleStatus()
    {
        return $this->only(['id', 'status'])
            ->append('id', 'require|integer|egt:2|exists:admin')
            ->append('status', 'require|in:' . BaseStatus::DISABLE . ',' . BaseStatus::ENABLE);
    }

    public function sceneEdit()
    {
        return $this->only(['id'])
            ->append('id', 'require|integer|egt:2|exists:admin');
    }

    public function sceneUpdate()
    {
        return $this->remove('password', 'require')
            ->remove('re_password', 'require')
            ->append('re_password', 'requireWith:password')
            ->append('id', 'require|integer|egt:2|exists:admin')
            ->append('status', 'require|in:' . BaseStatus::DISABLE . ',' . BaseStatus::ENABLE);
    }
}