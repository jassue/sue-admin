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
            ['id'=>1, 'parent_id'=>0, 'name'=>'所有权限', 'url'=>'all'],
            ['id'=>2, 'parent_id'=>1, 'name'=>'控制台', 'url'=>'/admin'],
            ['id'=>3, 'parent_id'=>1, 'name'=>'权限管理', 'url'=>'auth'],
            ['id'=>4, 'parent_id'=>3, 'name'=>'菜单管理', 'url'=>'menu'],
            ['id'=>5, 'parent_id'=>4, 'name'=>'菜单列表', 'url'=>'/admin/menu'],
            ['id'=>6, 'parent_id'=>4, 'name'=>'添加菜单', 'url'=>'/admin/menu/create'],
            ['id'=>7, 'parent_id'=>4, 'name'=>'编辑菜单', 'url'=>'/admin/menu/edit'],
            ['id'=>8, 'parent_id'=>4, 'name'=>'删除菜单', 'url'=>'/admin/menu/delete'],
            ['id'=>9, 'parent_id'=>3, 'name'=>'角色管理', 'url'=>'role'],
            ['id'=>10, 'parent_id'=>9, 'name'=>'角色列表', 'url'=>'/admin/role'],
            ['id'=>11, 'parent_id'=>9, 'name'=>'添加角色', 'url'=>'/admin/role/create'],
            ['id'=>12, 'parent_id'=>9, 'name'=>'编辑角色', 'url'=>'/admin/role/edit'],
            ['id'=>13, 'parent_id'=>9, 'name'=>'删除角色', 'url'=>'/admin/role/delete'],
            ['id'=>14, 'parent_id'=>3, 'name'=>'管理员管理', 'url'=>' admin'],
            ['id'=>15, 'parent_id'=>14, 'name'=>'管理员列表', 'url'=>'/admin/admin'],
            ['id'=>16, 'parent_id'=>14, 'name'=>'添加管理员', 'url'=>'/admin/admin/create'],
            ['id'=>17, 'parent_id'=>14, 'name'=>'切换管理员状态', 'url'=>'/admin/admin/toggle'],
            ['id'=>18, 'parent_id'=>14, 'name'=>'编辑管理员', 'url'=>'/admin/admin/edit'],
            ['id'=>19, 'parent_id'=>14, 'name'=>'删除管理员', 'url'=>'/admin/admin/delete'],
            ['id'=>20, 'parent_id'=>3, 'name'=>'权限管理', 'url'=>'rule'],
            ['id'=>21, 'parent_id'=>20, 'name'=>'权限列表', 'url'=>'/admin/rule'],
            ['id'=>22, 'parent_id'=>20, 'name'=>'添加权限', 'url'=>'/admin/rule/create'],
            ['id'=>23, 'parent_id'=>20, 'name'=>'编辑权限', 'url'=>'/admin/rule/edit'],
            ['id'=>24, 'parent_id'=>20, 'name'=>'删除权限', 'url'=>'/admin/rule/delete'],
        ]);
        AdminRoles::allocationRules($role, [1]);
        AdminMenus::createMany([
            ['id'=>1, 'parent_id'=>0, 'name'=>'控制台', 'icon'=>'fa-dashboard', 'url'=>'/admin'],
            ['id'=>2, 'parent_id'=>0, 'name'=>'权限管理', 'icon'=>'fa-cube', 'url'=>''],
            ['id'=>3, 'parent_id'=>2, 'name'=>'角色管理', 'icon'=>'fa-circle-o', 'url'=>'/admin/role'],
            ['id'=>4, 'parent_id'=>2, 'name'=>'管理员', 'icon'=>'fa-circle-o', 'url'=>'/admin/admin'],
            ['id'=>5, 'parent_id'=>2, 'name'=>'权限列表', 'icon'=>'fa-circle-o', 'url'=>'/admin/rule'],
            ['id'=>6, 'parent_id'=>2, 'name'=>'后台菜单', 'icon'=>'fa-circle-o', 'url'=>'/admin/menu'],
        ]);
    }
}