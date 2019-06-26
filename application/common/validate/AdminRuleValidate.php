<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/23
 * Time: 19:27
 */

namespace app\common\validate;


class AdminRuleValidate extends BaseValidate
{
    protected $rule = [
        'parent_id' => 'require|egt:1|exists:admin_rule,id',
        'name'      => 'require|max:10|unique:admin_rule',
        'url'       => 'require|max:50|unique:admin_rule'
    ];

    protected $message = [
        'id.require'        => 'id不能为空',
        'id.integer'        => 'id必须为整数',
        'id.egt'            => 'id数据错误',
        'id.exists'         => 'id不存在',
        'parent_id.require' => '上级权限不能为空',
        'parent_id.egt'     => '上级权限非法，请勿篡改',
        'parent_id.exists'  => '该上级权限不存在',
        'name.require'      => '请输入名称',
        'name.max'          => '名称最多为10个字符',
        'name.unique'       => '名称已存在',
        'url.require'       => '链接不能为空',
        'url.max'           => '链接长度最大为50',
        'url.unique'        => '链接已存在',
    ];

    public function sceneEdit()
    {
        return $this->only(['id'])
            ->append('id', 'require|integer|egt:2|exists:admin_rule');
    }

    public function sceneUpdate()
    {
        return $this->append('id', 'require|integer|egt:2|exists:admin_rule');
    }
}