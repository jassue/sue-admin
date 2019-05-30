<?php

use think\migration\Seeder;
use \app\service\facade\Admins;
use \app\service\facade\AdminRoles;
use \app\service\facade\AdminRules;
use \app\service\facade\AdminMenus;

class InitSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $admin = Admins::create('admin', 'admin', '123456', '');
        $role = AdminRoles::create('超级管理员');
        Admins::bindRoles($admin, [$role->id]);
        AdminRules::createMany([
            ['id'=>1, 'parent_id'=>0, 'title'=>'所有权限', 'name'=>'ALL'],
            ['id'=>2, 'parent_id'=>1, 'title'=>'权限管理', 'name'=>'ACCESS_MANAGE'],
            ['id'=>3, 'parent_id'=>2, 'title'=>'后台菜单', 'name'=>'ADMIN_MENU_LIST'],
            ['id'=>4, 'parent_id'=>3, 'title'=>'添加菜单', 'name'=>'CREATE_ADMIN_MENU'],
            ['id'=>5, 'parent_id'=>3, 'title'=>'编辑菜单', 'name'=>'EDIT_ADMIN_MENU'],
            ['id'=>6, 'parent_id'=>3, 'title'=>'删除菜单', 'name'=>'DELETE_ADMIN_MENU'],
            ['id'=>7, 'parent_id'=>2, 'title'=>'角色管理', 'name'=>'ROLE_LIST'],
            ['id'=>8, 'parent_id'=>7, 'title'=>'添加角色', 'name'=>'CREATE_ROLE'],
            ['id'=>9, 'parent_id'=>7, 'title'=>'编辑角色', 'name'=>'EDIT_ROLE'],
            ['id'=>10, 'parent_id'=>7, 'title'=>'分配权限', 'name'=>'ALLOCATION_RULE'],
            ['id'=>11, 'parent_id'=>7, 'title'=>'删除角色', 'name'=>'DELETE_ROLE'],
            ['id'=>12, 'parent_id'=>2, 'title'=>'管理员', 'name'=>'ADMIN_LIST'],
            ['id'=>13, 'parent_id'=>12, 'title'=>'添加管理员', 'name'=>'CREATE_ADMIN'],
            ['id'=>14, 'parent_id'=>12, 'title'=>'编辑管理员', 'name'=>'EDIT_ADMIN'],
            ['id'=>15, 'parent_id'=>12, 'title'=>'删除管理员', 'name'=>'ADMIN_MANAGE'],
            ['id'=>16, 'parent_id'=>2, 'title'=>'权限列表', 'name'=>'RULE_LIST'],
            ['id'=>17, 'parent_id'=>16, 'title'=>'添加权限', 'name'=>'CREATE_RULE'],
            ['id'=>18, 'parent_id'=>16, 'title'=>'编辑权限', 'name'=>'EDIT_RULE'],
            ['id'=>19, 'parent_id'=>16, 'title'=>'删除权限', 'name'=>'DELETE_RULE'],
        ]);
        AdminRoles::allocationRules($role, [1]);
        AdminMenus::createMany([
            ['id'=>1, 'parent_id'=>0, 'rule_id'=>0, 'name'=>'控制台', 'icon'=>'fa-dashboard', 'url'=>'/admin'],
            ['id'=>2, 'parent_id'=>0, 'rule_id'=>2, 'name'=>'权限管理', 'icon'=>'fa-cube', 'url'=>''],
            ['id'=>3, 'parent_id'=>2, 'rule_id'=>7, 'name'=>'角色管理', 'icon'=>'fa-circle-o', 'url'=>'/admin/role'],
            ['id'=>4, 'parent_id'=>2, 'rule_id'=>12, 'name'=>'管理员', 'icon'=>'fa-circle-o', 'url'=>'/admin/admin'],
            ['id'=>5, 'parent_id'=>2, 'rule_id'=>16, 'name'=>'权限列表', 'icon'=>'fa-circle-o', 'url'=>'/admin/rule'],
            ['id'=>6, 'parent_id'=>2, 'rule_id'=>3, 'name'=>'后台菜单', 'icon'=>'fa-circle-o', 'url'=>'/admin/menu'],
        ]);
    }
}