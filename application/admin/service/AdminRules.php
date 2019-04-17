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
}