<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:21
 */

namespace app\common\model;


use app\common\enum\BaseStatus;

class Admin extends BaseUser
{
    /**
     * @return \think\model\relation\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, AdminRoleRelation::class, 'role_id', 'admin_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getStatusAttr($value)
    {
        return BaseStatus::$statusMap[$value];
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getLastLoginTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d H:i:s', $value) : '';
    }
}