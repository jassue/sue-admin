<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:21
 */

namespace app\common\model;


class Admin extends BaseUser
{
    /**
     * @return \think\model\relation\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, AdminRoleRelation::class, 'role_id', 'admin_id');
    }

}