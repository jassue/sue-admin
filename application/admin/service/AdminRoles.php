<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:46
 */

namespace app\admin\service;


use app\common\enum\BaseStatus;
use app\common\model\AdminRole;

class AdminRoles
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return AdminRole::getOrFail($id);
    }

    /**
     * @param string $name
     * @return AdminRole
     */
    public function create(string $name)
    {
        return AdminRole::create([
            'name' => $name,
            'status' => BaseStatus::ENABLE
        ]);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     */
    public function allocationRules(AdminRole $adminRole, array $ruleIds)
    {
        $insertData = [];
        foreach ($ruleIds as $ruleId) {
            $insertData[] = ['rule_id' => $ruleId];
        }
        $adminRole->ruleRelation()->saveAll($insertData);
    }
}