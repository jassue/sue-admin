<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/26
 * Time: 22:03
 */

namespace app\common\validate;


class AdminMenuValidate extends BaseValidate
{
    protected $rule = [
        'parent_id' => 'require|integer|egt:0',
        'icon'      => 'max:30',
        'name'      => 'require|max:10|unique:admin_menu',
        'url'       => 'max:50'
    ];

    protected $message = [
        'id.require'        => 'id不能为空',
        'id.integer'        => 'id必须为整数',
        'id.egt'            => 'id数据错误',
        'id.exists'         => 'id不存在',
        'parent_id.require' => '上级菜单不能为空',
        'parent_id.integer' => '上级菜单数据格式错误',
        'parent_id.egt'     => '上级菜单非法，请勿篡改',
        'icon.max'          => '图标长度最多为30个字符',
        'name.require'      => '请输入名称',
        'name.max'          => '名称最多为10个字符',
        'name.unique'       => '名称已存在',
        'url.max'           => '链接长度最大为50',
    ];

    public function sceneEdit()
    {
        return $this->only(['id'])
            ->append('id', 'require|integer|egt:1|exists:admin_menu');
    }

    public function sceneUpdate()
    {
        return $this->append('id', 'require|integer|egt:1|exists:admin_menu');
    }
}