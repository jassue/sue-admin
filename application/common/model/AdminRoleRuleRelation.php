<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:31
 */

namespace app\common\model;


use think\model\Pivot;

class AdminRoleRuleRelation extends Pivot
{
    protected $autoWriteTimestamp = 'datetime';
}