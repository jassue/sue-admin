<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:33
 */

namespace app\admin\service;


use app\common\enum\BaseStatus;
use app\common\model\Admin;

class Admins
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Admin::getOrFail($id);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $mobile
     * @return Admin
     */
    public function create(string $username, string $password, string $mobile)
    {
        return Admin::create([
            'username' => $username,
            'password' => Admin::makePassword($password),
            'mobile_phone' => $mobile,
            'status' => BaseStatus::ENABLE
        ]);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     */
    public function bindRoles(Admin $admin, array $roleIds)
    {
        $insertData = [];
        foreach ($roleIds as $roleId) {
            $insertData[] = ['role_id' => $roleId];
        }
        $admin->roleRelation()->saveAll($insertData);
    }
}