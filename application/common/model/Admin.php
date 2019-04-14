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
     * @return \think\model\relation\HasMany
     */
    public function roleRelation()
    {
        return $this->hasMany(AdminRoleRelation::class, 'admin_id', 'id');
    }
    /**
     * @return \think\model\relation\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_role_relation', 'admin_id', 'id');
    }

}