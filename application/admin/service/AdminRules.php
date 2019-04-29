<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 21:09
 */

namespace app\admin\service;


use app\common\model\Admin;
use app\common\model\AdminRule;

class AdminRules
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return AdminRule::getOrFail($id);
    }

    /**
     * @param int $parentId
     * @param string $title
     * @param string $name
     * @return AdminRule
     */
    public function create(int $parentId, string $title, string $name)
    {
        return AdminRule::create([
            'parent_id' => $parentId,
            'title' => $title,
            'name' => $name
        ]);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createMany(array $data)
    {
        return (new AdminRule)->saveAll($data, false)->column('id');
    }

    /**
     * @param Admin $admin
     * @param string $auth
     * @return bool
     */
    public function checkRuleByAdmin(Admin $admin, string $auth)
    {
        $result = false;
        $admin->roles->each(function ($role) use ($auth, &$result) {
            if ($role->id == 1)
                $result = true;
            $exists = $role->rules()->where('name', $auth)->find();
            if ($exists)
                $result = true;
        });
        return $result;
    }

    /**
     * @param Admin $admin
     * @return array
     */
    public function getRuleNameArrByAdmin(Admin $admin)
    {
        $ruleNameArr = [];
        foreach ($admin->roles as $role) {
            $ruleNameArr = array_merge($ruleNameArr, $role->rules->column('name'));
        }
        return array_unique($ruleNameArr);
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return AdminRule::with('child.child')->where('parent_id', 1)->select();
    }

    /**
     * @param array $post
     */
    public function edit(array $post)
    {
        AdminRule::update($post);
    }

    /**
     * @param array $ids
     */
    public function delete(array $ids)
    {
        AdminRule::destroy($ids);
    }
}