<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:34
 */

namespace app\admin\facade;


use think\Facade;

class Admins extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\admin\service\Admins';
    }
}