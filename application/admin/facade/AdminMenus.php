<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/20
 * Time: 17:33
 */

namespace app\admin\facade;


use think\Facade;

class AdminMenus extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\admin\service\AdminMenus';
    }
}