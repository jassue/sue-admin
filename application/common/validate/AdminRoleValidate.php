<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/8
 * Time: 11:27
 */

namespace app\common\validate;


class AdminRoleValidate extends BaseValidate
{
    protected $rule = [
        'name'    => 'require|max:10|unique:admin_role',
        'rules'   => 'require|array'
    ];

    protected $message = [
        'id.require'    => 'id不能为空',
        'id.integer'    => 'id必须为整数',
        'id.egt'        => 'id数据错误',
        'id.exists'     => 'id不存在',
        'name.require'  => '请输入名称',
        'name.max'      => '名称最多为10个字符',
        'name.unique'   => '名称已存在',
        'rules.require' => '请选择权限',
        'rules.array'   => '权限格式不正确',
        'rules.notIn'   => '非法选择权限'
    ];

    public function sceneEdit()
    {
        return $this->only(['id'])
            ->append('id', 'require|integer|eqt:2|exists:admin_role');
    }

    public function sceneUpdate()
    {
        return $this->append('id', 'require|integer|eqt:2|exists:admin_role');
    }
}