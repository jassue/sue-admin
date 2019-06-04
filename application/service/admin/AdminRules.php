<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 21:09
 */

namespace app\service\admin;


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
     * @param string $name
     * @param string $url
     * @return AdminRule
     */
    public function create(int $parentId, string $name, string $url)
    {
        return AdminRule::create([
            'parent_id' => $parentId,
            'title'     => $name,
            'url'       => $url
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
     * @param string $url
     * @return bool
     */
    public function checkRuleByAdmin(Admin $admin, string $url)
    {
        $result = false;
        $admin->roles->each(function ($role) use ($url, &$result) {
            if ($role->id == 1) {
                $result = true;
            } else {
                $exists = $role->rules()->where('url', $url)->find();
                if ($exists)
                    $result = true;
            }
        });
        return $result;
    }

    /**
     * @param Admin $admin
     * @return array
     */
    public function getUrlsByAdmin(Admin $admin)
    {
        $ruleUrls = [];
        foreach ($admin->roles as $role) {
            $ruleUrls = array_merge($ruleUrls, $role->rules->column('url'));
        }
        return array_unique($ruleUrls);
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChildList()
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