<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/20
 * Time: 17:32
 */

namespace app\admin\service;


use app\common\model\Admin;
use app\common\model\AdminMenu;
use app\admin\facade\AdminRules;

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
     * @param string $name
     * @param string $icon
     * @param string $url
     * @param string $rule
     * @return AdminMenu
     */
    public function create(int $parentId, string $name, string $icon = '', string $url = '', string $rule = '')
    {
        return AdminMenu::create([
           'parent_id' => $parentId,
            'name' => $name,
            'icon' => $icon,
            'url' => $url,
            'rule' => $rule,
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
        $ruleNameArr = AdminRules::getRuleNameArrByAdmin($admin);
        $isSuperAdmin = in_array('ALL', $ruleNameArr) ?? false;
        $query = AdminMenu::where('parent_id', 0);
        if (!$isSuperAdmin) {
            $query->where(
                function ($query) use ($ruleNameArr) {
                    $query
                        ->whereIn('rule', $ruleNameArr)
                        ->whereOr('rule', '');
                }
            );
        }
        $menuList = $query->select()->each(
            function ($menu) use ($ruleNameArr, $isSuperAdmin) {
                if ($isSuperAdmin)
                    $menu->child;
                else
                    $menu->child = $menu->child()->whereIn('rule', $ruleNameArr)->select();
                return $menu;
            }
        );
        return $menuList->toArray();
    }
}