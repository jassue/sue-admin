<?php

use think\migration\Seeder;
use \app\admin\facade\Admins;
use \app\admin\facade\AdminRoles;
use \app\admin\facade\AdminRules;

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
        $admin = Admins::create('admin', '123456', '');
        $role = AdminRoles::create('超级管理员');
        $rule = AdminRules::create(0, '超级管理员', 'all');
        Admins::bindRoles($admin, [$role->id]);
        AdminRoles::allocationRules($role, [$rule->id]);
    }
}