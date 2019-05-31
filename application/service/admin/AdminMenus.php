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
     * @param string $name
     * @param string $icon
     * @param string $url
     * @return AdminMenu
     */
    public function create(int $parentId, string $name, $icon = '', $url = '')
    {
        return AdminMenu::create([
            'parent_id' => $parentId,
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
        $ruleUrls = AdminRules::getUrlsByAdmin($admin);
        $isSuperAdmin = in_array('all', $ruleUrls) ?? false;
        $query = AdminMenu::with('child')->where('parent_id', 0);
        if (!$isSuperAdmin) {
            $query->where(
                function ($query) use ($ruleUrls) {
                    $query
                        ->whereIn('url', $ruleUrls)
                        ->whereOr('url', '');
                }
            );
        }
        $menuList = $query->select()->map(
            function (AdminMenu $menu) use ($ruleUrls, $isSuperAdmin) {
                if ($isSuperAdmin) {
                    $result = $menu->child;
                } else {
                    $result = $menu->child->where('url', 'in', $ruleUrls);
                }
                !$result->isEmpty() && $menu->children = $result;
                if ($menu->url != '' || ($menu->url == '' && isset($menu->children))) {
                    unset($menu->child);
                    return $menu;
                }
            }
        )->filter(function ($item) {
            return !is_null($item);
        });

        return $menuList->toArray();
    }
}