<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/20
 * Time: 17:32
 */

namespace app\service\admin;


use app\common\model\Admin;
use app\common\model\AdminMenu;
use app\service\facade\AdminRules;

class AdminMenus
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return AdminMenu::getOrFail($id);
    }

    /**
     * @param int $parentId
     * @param int $ruleId
     * @param string $name
     * @param string $icon
     * @param string $url
     * @return AdminMenu
     */
    public function create(int $parentId, int $ruleId, string $name, $icon = '', $url = '')
    {
        return AdminMenu::create([
            'parent_id' => $parentId,
            'rule_id'   => $ruleId,
            'name'      => $name,
            'icon'      => $icon,
            'url'       => $url,
        ]);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createMany(array $data)
    {
        return (new AdminMenu())->saveAll($data, false)->column('id');
    }

    /**
     * @param Admin $admin
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListByAdmin(Admin $admin)
    {
        $ruleIds = AdminRules::getRuleIdsByAdmin($admin);
        $isSuperAdmin = in_array(1, $ruleIds) ?? false;
        $query = AdminMenu::where('parent_id', 0);
        if (!$isSuperAdmin) {
            $query->where(
                function ($query) use ($ruleIds) {
                    $query
                        ->whereIn('rule_id', $ruleIds)
                        ->whereOr('rule_id', 0);
                }
            );
        }
        $menuList = $query->select()->each(
            function ($menu) use ($ruleIds, $isSuperAdmin) {
                if ($isSuperAdmin)
                    $menu->child;
                else
                    $menu->child = $menu->child()->whereIn('rule', $ruleIds)->select();
                return $menu;
            }
        );
        return $menuList->toArray();
    }
}