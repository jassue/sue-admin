<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:34
 */

namespace app\service\facade;


use think\Facade;

class AdminRoles extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\service\admin\AdminRoles';
    }
}