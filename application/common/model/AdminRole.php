<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:24
 */

namespace app\common\model;


class AdminRole extends BaseModel
{
    /**
     * @return \think\model\relation\HasMany
     */
    public function ruleRelation()
    {
        return $this->hasMany(AdminRoleRuleRelation::class, 'role_id', 'id');
    }
}