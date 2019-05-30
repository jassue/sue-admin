<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:30
 */

namespace app\common\model;


class AdminRule extends BaseModel
{
    /**
     * @return \think\model\relation\HasMany
     */
    public function child()
    {
        return $this->hasMany(AdminRule::class, 'parent_id', 'id');
    }
}