<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:46
 */

namespace app\service\admin;


use app\common\enum\BaseStatus;
use app\common\model\AdminRole;
use app\common\model\AdminRoleRelation;
use app\common\model\AdminRoleRuleRelation;

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
            'name'   => $name,
        ]);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     * @throws \think\Exception
     */
    public function allocationRules(AdminRole $adminRole, array $ruleIds)
    {
        $adminRole->rules()->attach($ruleIds);
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return AdminRole::all();
    }

    /**
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getPaginateList(int $page, int $size)
    {
        return AdminRole::paginate($size,false, ['page' => $page]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getInfoById(int $id)
    {
        $adminRole = $this->getById($id);
        $adminRole->ruleIds = $adminRole->rules()->select()->column('id');
        return $adminRole;
    }

    /**
     * @param $post
     */
    public function update(array $post)
    {
        $data['id'] = $post['id'];
        isset($post['name']) && $data['name'] = $post['name'];
        AdminRole::update($data);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     * @throws \think\Exception
     */
    public function toggleRules(AdminRole $adminRole, array $ruleIds)
    {
        $curRuleIds = $adminRole->rules()->select()->column('id');
        $needUnbindIds = [];
        foreach ($curRuleIds as $ruleId) {
            if (!in_array($ruleId, $ruleIds))
                array_push($needUnbindIds, $ruleId);
            else
                $ruleIds = array_merge(array_diff($ruleIds, array($ruleId)));
        }
        !empty($needUnbindIds) && $this->revokeRules($adminRole, $needUnbindIds);
        !empty($ruleIds) && $this->allocationRules($adminRole, $ruleIds);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     */
    public function revokeRules(AdminRole $adminRole, array $ruleIds)
    {
        $adminRole->rules()->detach($ruleIds);
    }

    /**
     * @param array $ids
     */
    public function delete(array $ids)
    {
        $ruleRelationIds = AdminRoleRuleRelation::whereIn('role_id', $ids)->column('id');
        $roleRelationIds = AdminRoleRelation::whereIn('role_id', $ids)->column('id');
        AdminRoleRuleRelation::destroy($ruleRelationIds);
        AdminRoleRelation::destroy($roleRelationIds);
        AdminRole::destroy($ids);
    }
}