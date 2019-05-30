<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/20
 * Time: 17:31
 */

namespace app\common\model;


class AdminMenu extends BaseModel
{
    protected $hidden = [
        'rule'
    ];

    /**
     * @return \think\model\relation\HasMany
     */
    public function child()
    {
        return $this->hasMany(AdminMenu::class, 'parent_id', 'id');
    }

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo(AdminRule::class, 'rule_id', 'id');
    }
}