<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 21:09
 */

namespace app\admin\service;


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
            'name' => $name,
            'url' => $url
        ]);
    }
}